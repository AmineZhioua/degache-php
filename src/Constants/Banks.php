<?php

declare(strict_types=1);

namespace AmineZhioua\DegachePhp\Constants;

final class Banks
{
    /**
     * @var array<string, array{code: string, name: string}>
     */
    public const array BANKS = [
        'ATB' => ['code' => '01', 'name' => 'Arab Tunisian Bank'],
        'BIAT' => ['code' => '08', 'name' => 'Banque Internationale Arabe de Tunisie'],
        'BNA' => ['code' => '03', 'name' => 'Banque Nationale Agricole'],
        'BH' => ['code' => '14', 'name' => "Banque de l'Habitat"],
        'STB' => ['code' => '10', 'name' => 'Société Tunisienne de Banque'],
        'UIB' => ['code' => '12', 'name' => 'Union Internationale de Banques'],
        'UBCI' => ['code' => '04', 'name' => 'Union Bancaire pour le Commerce et l\'Industrie'],
        'BT' => ['code' => '05', 'name' => 'Banque de Tunisie'],
        'AMEN' => ['code' => '07', 'name' => 'Amen Bank'],
        'ATTIJARI' => ['code' => '11', 'name' => 'Attijari Bank'],
        'BTK' => ['code' => '20', 'name' => 'Banque Tuniso-Koweïtienne'],
        'BTL' => ['code' => '25', 'name' => 'Banque Tuniso-Libyenne'],
        'BTE' => ['code' => '16', 'name' => 'Banque Tuniso-Emirats'],
        'ZITOUNA' => ['code' => '26', 'name' => 'Banque Zitouna'],
        'POSTE' => ['code' => '17', 'name' => 'La Poste Tunisienne'],
    ];

    /**
     * Finds a bank by its 2-digit code.
     *
     * @return array{code: string, name: string}|null
     */
    public static function findByCode(string $code): ?array
    {
        foreach (self::BANKS as $bank) {
            if ($bank['code'] === $code) {
                return $bank;
            }
        }

        return null;
    }
}