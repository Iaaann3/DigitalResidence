<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class UsersImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure, SkipsEmptyRows
{
    private array $errors = [];
    private array $failures = [];
    private int $importedCount = 0;

    public function model(array $row)
    {
        if (!isset($row['nama']) || empty(trim($row['nama']))) {
            return null;
        }

        $this->importedCount++;

        return new User([
            'name'      => $row['nama'],
            'email'     => $row['email'],
            'no_rumah'  => strtoupper(trim($row['no_rumah'])),
            'no_tlp'    => $row['no_tlp'],
            'alamat'    => $row['alamat'],
            'password'  => Hash::make($row['password'] ?? 'password123'),
            'role'      => 'user',
        ]);
    }

    // Dipanggil saat exception (misal: DB error)
    public function onError(Throwable $e): void
    {
        $this->errors[] = $e->getMessage();
    }

    // Dipanggil saat validasi gagal (duplicate, format salah, dll)
    public function onFailure(Failure ...$failures): void
    {
        foreach ($failures as $failure) {
            $this->failures[] = [
                'row'    => $failure->row(),
                'field'  => $failure->attribute(),
                'errors' => $failure->errors(),
                'values' => $failure->values(),
            ];
        }
    }

    public function rules(): array
    {
        return [
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'no_rumah' => 'required|string|unique:users,no_rumah',
            'no_tlp'   => 'required|string|max:20',
            'alamat'   => 'required|string|max:500',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'nama.required'   => 'Kolom Nama wajib diisi',
            'email.unique'    => 'Email :input sudah terdaftar',
            'email.email'     => 'Format email :input tidak valid',
            'no_rumah.unique' => 'No Rumah :input sudah terdaftar',
        ];
    }

    // Getter buat controller
    public function getFailures(): array  { return $this->failures; }
    public function getErrors(): array    { return $this->errors; }
    public function getImportedCount(): int { return $this->importedCount; }
}