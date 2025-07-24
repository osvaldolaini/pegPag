<?php

namespace App\Traits;

trait PixQqrCode
{
    private function generatePixPayload($pixKey, $merchantName, $merchantCity, $txid, $amount = null)
    {
        // Função auxiliar para formatar campos EMV
        $formatField = fn($id, $value) => str_pad(strlen($value), 2, '0', STR_PAD_LEFT) . $id . $value;

        $payload = '';
        $payload .= '00' . '02' . '01'; // Payload Format Indicator (ID 00)
        $payload .= '01' . '02' . '12'; // Point of Initiation Method (ID 01, 12 = dinâmico)

        // Merchant Account Information - Pix (ID 26)
        $gui = 'br.gov.bcb.pix';
        $keyField = '01' . str_pad(strlen($pixKey), 2, '0', STR_PAD_LEFT) . $pixKey;
        $guiField = '00' . str_pad(strlen($gui), 2, '0', STR_PAD_LEFT) . $gui;
        $merchantAccountInfo = $guiField . $keyField;
        $payload .= '26' . str_pad(strlen($merchantAccountInfo), 2, '0', STR_PAD_LEFT) . $merchantAccountInfo;

        // Merchant Category Code (ID 52) - default 0000
        $payload .= '52' . '04' . '0000';

        // Transaction Currency (ID 53) - 986 = BRL
        $payload .= '53' . '03' . '986';

        // Transaction Amount (ID 54) - opcional
        if ($amount !== null) {
            $amount = number_format($amount, 2, '.', '');
            $payload .= '54' . str_pad(strlen($amount), 2, '0', STR_PAD_LEFT) . $amount;
        }

        // Country Code (ID 58)
        $payload .= '58' . '02' . 'BR';

        // Merchant Name (ID 59)
        $merchantName = strtoupper(substr($merchantName, 0, 25)); // max 25 chars
        $payload .= '59' . str_pad(strlen($merchantName), 2, '0', STR_PAD_LEFT) . $merchantName;

        // Merchant City (ID 60)
        $merchantCity = strtoupper(substr($merchantCity, 0, 15)); // max 15 chars
        $payload .= '60' . str_pad(strlen($merchantCity), 2, '0', STR_PAD_LEFT) . $merchantCity;

        // Additional Data Field Template (ID 62)
        $txidField = '05' . str_pad(strlen($txid), 2, '0', STR_PAD_LEFT) . $txid;
        $additionalDataField = '62' . str_pad(strlen($txidField), 2, '0', STR_PAD_LEFT) . $txidField;
        $payload .= $additionalDataField;

        // CRC16 (ID 63) - Calculado no final
        $payload .= '63' . '04';

        // Calcular CRC16 conforme padrão ISO/IEC 13239
        $crc = $this->calculateCrc16($payload);
        $payload .= strtoupper($crc);

        return $payload;
    }

    private function calculateCrc16($payload)
    {
        $polynomial = 0x1021;
        $result = 0xFFFF;

        $payload = utf8_encode($payload);

        for ($i = 0; $i < strlen($payload); $i++) {
            $result ^= (ord($payload[$i]) << 8);
            for ($j = 0; $j < 8; $j++) {
                if (($result & 0x8000) != 0) {
                    $result = ($result << 1) ^ $polynomial;
                } else {
                    $result <<= 1;
                }
                $result &= 0xFFFF;
            }
        }

        return strtoupper(sprintf('%04X', $result));
    }
}
