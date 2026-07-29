<?php

declare(strict_types=1);

namespace AmineZhioua\DegachePhp\Validators;

use AmineZhioua\DegachePhp\Constants\Banks;
use AmineZhioua\DegachePhp\DTO\BankInfo;

final class RibValidator
{
    private const string RIB_REGEX = '/^\d{20}$/';
    private const string BRANCH_CODE_REGEX = '/^\d{3}$/';
    private const string ACCOUNT_NUMBER_REGEX = '/^\d{13}$/';
    private const string KEY_REGEX = '/^\d{2}$/';

    /**
     * Validates a Tunisian RIB (Relevé d'Identité Bancaire).
    */
    public static function validate(?string $rib): bool
    {
        if ($rib === null || preg_match(self::RIB_REGEX, $rib) !== 1) {
            return false;
        }

        $bankCode = substr($rib, 0, 2);
        $branchCode = substr($rib, 2, 3);
        $accountNumber = substr($rib, 5, 13);
        $key = substr($rib, 18, 2);

        if (Banks::findByCode($bankCode) === null) {
            return false;
        }

        if (preg_match(self::BRANCH_CODE_REGEX, $branchCode) !== 1) {
            return false;
        }

        if (preg_match(self::ACCOUNT_NUMBER_REGEX, $accountNumber) !== 1) {
            return false;
        }

        return preg_match(self::KEY_REGEX, $key) === 1;
    }

    public static function getBankFromRib(?string $rib): ?BankInfo
    {
        if ($rib === null || preg_match(self::RIB_REGEX, $rib) !== 1) {
            return null;
        }

        $bankCode = substr($rib, 0, 2);
        $bank = Banks::findByCode($bankCode);

        return $bank !== null ? new BankInfo($bank['code'], $bank['name']) : null;
    }
}