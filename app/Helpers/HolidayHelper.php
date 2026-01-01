<?php

namespace App\Helpers;

use Carbon\Carbon;

class HolidayHelper
{
    /**
     * Daftar hari libur nasional Indonesia tahun 2025-2026
     * Update setiap tahun sesuai keputusan pemerintah
     */
    private static function nationalHolidays(): array
    {
        return [
            // 2025
            '2025-01-01', // Tahun Baru Masehi
            '2025-01-29', // Tahun Baru Imlek
            '2025-03-29', // Hari Raya Nyepi
            '2025-03-31', // Isra Mi'raj Nabi Muhammad SAW
            '2025-04-18', // Wafat Isa Al-Masih
            '2025-04-20', // Paskah
            '2025-05-01', // Hari Buruh Internasional
            '2025-05-12', // Hari Raya Waisak
            '2025-05-29', // Kenaikan Isa Al-Masih
            '2025-06-01', // Hari Lahir Pancasila
            '2025-06-17', // Hari Raya Idul Fitri (cuti bersama)
            '2025-06-18', // Hari Raya Idul Fitri (cuti bersama)
            '2025-08-17', // Hari Kemerdekaan RI
            '2025-08-27', // Hari Raya Idul Adha
            '2025-09-17', // Tahun Baru Islam 1447 H
            '2025-11-26', // Maulid Nabi Muhammad SAW
            '2025-12-25', // Hari Raya Natal
            
            // 2026 (tambahkan sesuai keputusan pemerintah)
            '2026-01-01', // Tahun Baru Masehi
            // dst...
        ];
    }

    /**
     * Cek apakah hari ini adalah hari Jumat
     */
    public static function isFriday(?Carbon $date = null): bool
    {
        $date = $date ?? Carbon::now();
        return $date->isFriday();
    }

    /**
     * Cek apakah tanggal adalah hari libur nasional
     */
    public static function isNationalHoliday(?Carbon $date = null): bool
    {
        $date = $date ?? Carbon::now();
        $dateString = $date->format('Y-m-d');
        
        return in_array($dateString, self::nationalHolidays());
    }

    /**
     * Cek apakah admin boleh mengubah harga (Jumat atau libur nasional)
     */
    public static function canUpdatePrice(?Carbon $date = null): bool
    {
        return self::isFriday($date) || self::isNationalHoliday($date);
    }

    /**
     * Get pesan kenapa tidak bisa update
     */
    public static function getUpdateRestrictionMessage(): string
    {
        $today = Carbon::now();
        
        if (self::canUpdatePrice($today)) {
            return '';
        }

        $nextFriday = $today->copy()->next(Carbon::FRIDAY);
        $nextHoliday = self::getNextNationalHoliday($today);

        $message = "Perubahan harga tiket hanya diperbolehkan pada hari Jumat atau hari libur nasional. ";
        
        if ($nextHoliday && $nextHoliday->lt($nextFriday)) {
            $message .= "Anda dapat mengubah harga pada " . $nextHoliday->isoFormat('dddd, D MMMM Y') . " (libur nasional).";
        } else {
            $message .= "Anda dapat mengubah harga pada " . $nextFriday->isoFormat('dddd, D MMMM Y') . ".";
        }

        return $message;
    }

    /**
     * Dapatkan hari libur nasional berikutnya
     */
    private static function getNextNationalHoliday(Carbon $date): ?Carbon
    {
        $holidays = self::nationalHolidays();
        $dateString = $date->format('Y-m-d');

        foreach ($holidays as $holiday) {
            if ($holiday > $dateString) {
                return Carbon::parse($holiday);
            }
        }

        return null;
    }

    /**
     * Get nama hari libur jika ada
     */
    public static function getHolidayName(?Carbon $date = null): ?string
    {
        $date = $date ?? Carbon::now();
        $dateString = $date->format('Y-m-d');

        $holidayNames = [
            '2025-01-01' => 'Tahun Baru Masehi',
            '2025-01-29' => 'Tahun Baru Imlek',
            '2025-03-29' => 'Hari Raya Nyepi',
            '2025-03-31' => 'Isra Mi\'raj Nabi Muhammad SAW',
            '2025-04-18' => 'Wafat Isa Al-Masih',
            '2025-04-20' => 'Paskah',
            '2025-05-01' => 'Hari Buruh Internasional',
            '2025-05-12' => 'Hari Raya Waisak',
            '2025-05-29' => 'Kenaikan Isa Al-Masih',
            '2025-06-01' => 'Hari Lahir Pancasila',
            '2025-06-17' => 'Hari Raya Idul Fitri (cuti bersama)',
            '2025-06-18' => 'Hari Raya Idul Fitri (cuti bersama)',
            '2025-08-17' => 'Hari Kemerdekaan RI',
            '2025-08-27' => 'Hari Raya Idul Adha',
            '2025-09-17' => 'Tahun Baru Islam 1447 H',
            '2025-11-26' => 'Maulid Nabi Muhammad SAW',
            '2025-12-25' => 'Hari Raya Natal',
            '2026-01-01' => 'Tahun Baru Masehi',
        ];

        return $holidayNames[$dateString] ?? null;
    }

    /**
     * Cek apakah user dapat booking di tanggal tertentu
     * User TIDAK BISA booking pada:
     * - Hari Jumat
     * - Hari libur nasional
     */
    public static function canBookOnDate(Carbon $date): bool
    {
        // Tidak bisa booking di hari Jumat
        if ($date->isFriday()) {
            return false;
        }

        // Tidak bisa booking di hari libur nasional
        if (self::isNationalHoliday($date)) {
            return false;
        }

        return true;
    }

    /**
     * Get daftar tanggal yang disabled untuk date picker
     * Format: ['2025-12-30', '2026-01-02', ...]
     */
    public static function getDisabledDates(?Carbon $startDate = null, ?Carbon $endDate = null): array
    {
        $startDate = $startDate ?? Carbon::now();
        $endDate = $endDate ?? Carbon::now()->addMonths(3);

        $disabledDates = [];
        $current = $startDate->copy();

        while ($current->lte($endDate)) {
            // Tambahkan jika Jumat atau libur nasional
            if (!self::canBookOnDate($current)) {
                $disabledDates[] = $current->format('Y-m-d');
            }
            $current->addDay();
        }

        return $disabledDates;
    }

    /**
     * Get message kenapa tanggal tidak bisa dipilih
     */
    public static function getBookingRestrictionMessage(Carbon $date): string
    {
        if ($date->isFriday()) {
            return 'Museum tutup setiap hari Jumat. Silakan pilih tanggal lain.';
        }

        if (self::isNationalHoliday($date)) {
            $holidayName = self::getHolidayName($date);
            return "Museum tutup pada tanggal ini (" . $holidayName . "). Silakan pilih tanggal lain.";
        }

        return '';
    }
}
