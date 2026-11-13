<?php

namespace App\Models\Backend;

use CodeIgniter\Database\BaseConnection;

final class BackendContactModel
{
    public function __construct(private readonly ?BaseConnection $database = null)
    {
    }

    /**
     * @return list<object>
     */
    public function contactMessages(): array
    {
        return $this->db()->table('tbl_contact')
            ->orderBy('contact_id', 'DESC')
            ->get()
            ->getResult();
    }

    public function contactMessage(int $contactId): ?object
    {
        $row = $this->db()->table('tbl_contact')
            ->where('contact_id', $contactId)
            ->get()
            ->getRow();

        return $row === null ? null : (object) $row;
    }

    public function deleteContactMessage(int $contactId): bool
    {
        return $this->db()->table('tbl_contact')
            ->where('contact_id', $contactId)
            ->delete();
    }

    /**
     * @return list<object>
     */
    public function complaintMessages(): array
    {
        return $this->db()->table('tbl_complaints')
            ->orderBy('complaint_id', 'DESC')
            ->get()
            ->getResult();
    }

    /**
     * @return list<object>
     */
    public function applicantMessages(): array
    {
        return $this->db()->table('tbl_applicant')
            ->select('tbl_applicant.*, country.country AS country_name, region.region AS state_name, city.city AS city_name')
            ->join('country', 'tbl_applicant.applicant_country = country.id', 'LEFT')
            ->join('region', 'tbl_applicant.applicant_state = region.id', 'LEFT')
            ->join('city', 'tbl_applicant.applicant_city = city.id', 'LEFT')
            ->orderBy('tbl_applicant.applicant_id', 'DESC')
            ->get()
            ->getResult();
    }

    /**
     * @return list<object>
     */
    public function customers(): array
    {
        return $this->db()->table('tbl_customer')
            ->where('delete_status', '0')
            ->orderBy('cus_id', 'DESC')
            ->get()
            ->getResult();
    }

    public function customer(int $customerId): ?object
    {
        $row = $this->db()->table('tbl_customer')
            ->where('cus_id', $customerId)
            ->get()
            ->getRow();

        return $row === null ? null : (object) $row;
    }

    /**
     * @return list<object>
     */
    public function countries(): array
    {
        return $this->db()->table('country')->get()->getResult();
    }

    /**
     * @return list<object>
     */
    public function statesForCountry(mixed $countryId): array
    {
        if (! is_scalar($countryId) || ! ctype_digit((string) $countryId)) {
            return [];
        }

        return $this->db()->table('region')
            ->where('country_id', (int) $countryId)
            ->get()
            ->getResult();
    }

    public function updateCustomer(int $customerId, array $customer): bool
    {
        return $this->db()->table('tbl_customer')
            ->where('cus_id', $customerId)
            ->update($customer);
    }

    public function softDeleteCustomer(int $customerId, int $userId, string $deletedOn): bool
    {
        return $this->db()->table('tbl_customer')
            ->where('cus_id', $customerId)
            ->update([
                'delete_status' => 1,
                'deleted_on' => $deletedOn,
                'deleted_by' => $userId,
            ]);
    }

    private function db(): BaseConnection
    {
        return $this->database ?? db_connect();
    }
}
