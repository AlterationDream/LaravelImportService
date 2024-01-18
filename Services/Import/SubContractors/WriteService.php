<?php

namespace App\Services\Import\SubContractors;

use App\Contractor;
use App\Helpers\StatusesHelperTender;
use App\Services\Import\Abstractions\DBWriteService;
use App\Services\Import\SubContractors\ImportModels\SubContract;
use App\Services\Import\SubContractors\ImportModels\SubInfo;
use App\SubContract as SubContractModel;
use App\SubPayment as SubPaymentModel;
use App\User;
use Exception;

/**
 * @inheritDoc
 * @see ImportFrom1CService     Вызывающий класс
 * @property SubContract[] $importedData
 */
class WriteService extends DBWriteService
{
    /** @var array  */  private $freshContractorsIDs;

    public function __construct(array &$importedData)
    {
        parent::__construct($importedData);
        $this->freshContractorsIDs = [];
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function importRecords()
    {
        foreach ($this->importedData as $subContractData)
        {
            $contractor = $this->importContractor($subContractData);
            $subContract = $this->importSubContract($subContractData, $contractor->id);
            $subContractData->subContractDBID = $subContract->id;
            $this->importSubPayments($subContractData);
        }
    }

    /**
     * Этап импорта соисполнителя.
     *
     * @param SubContract $subContractData
     * @return Contractor
     */
    private function importContractor(SubContract $subContractData): Contractor
    {
        // Пропустить импорт соисполнителя, если он уже есть в БД.
        $subInfo = $subContractData->getSubInfo();
        if (in_array($subInfo->subContractorID, $this->freshContractorsIDs))
            return Contractor::where('external_id_1c', $subInfo->subContractorID)->first();

        // Создание пользователя на сайте для соисполнителя.
        $user = User::firstOrCreate([
            'email' => $subInfo->subEmail ?? $this->generateContractorEmail($subInfo),
            'role' => 'contractor',
        ], ['password' => $this->generateContractorPassword()]);

        // Создание\обновление записи соисполнителя.
        $subInfo->userID = $user->id;
        if ($subInfo->subContractorFound)
        {
            $contractor = Contractor::where('external_id_1c', $subInfo->subContractorID)
                ->update($subInfo->getDBData());
        }
        else {
            $contractor = Contractor::create( $subInfo->getDBData() );

            // Изменить статус соисполнителя на 'Активен'
            $changeStatus = StatusesHelperTender::change_status('contractors', $contractor->id, 'active', true, null, '', false);
            if (!$changeStatus)
                StatusesHelperTender::set_status('contractors', $contractor->id, 'active', true);

            // Привязать запись о соисполнителе к пользователю.
            $user->contractors()->save($contractor);
        }

        // Добавление соисполнителя в список "свежих" при данном импорте.
        $this->freshContractorsIDs = $contractor->id;

        return $contractor;
    }

    /**
     * Генерирует email соисполнителя из переданных в массиве данных.
     *
     * @param SubInfo $info
     * @return string
     */
    private function generateContractorEmail(SubInfo $info): string
    {
        return $info->subContractorID . '@cstroy.ru';
    }

    /**
     * Генерирует пароль для нового соисполнителя.
     * @return string
     */
    private function generateContractorPassword(): string
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 10; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return bcrypt(implode($pass));
    }

    /**
     * Этап импорта под-контракта.
     *
     * @param SubContract $subContractData
     * @param int $contractorID
     * @return SubContractModel
     */
    private function importSubContract(SubContract $subContractData, int $contractorID): SubContractModel
    {
        $subContractData->subContractorID = $contractorID;

        return SubContractModel::firstOrCreate(
            ['external_id_1c' => $subContractData->externalID1C],
            $subContractData->getDBData()
        );
    }

    /**
     * Этап импорта оплат по под-контрактам.
     *
     * @param SubContract $subContractData
     * @throws Exception
     */
    private function importSubPayments(SubContract $subContractData)
    {
        $subContractData->setPaymentsData();
        foreach ($subContractData->subPayments as $subPayment)
            SubPaymentModel::firstOrCreate($subPayment->getDBData());
    }
}