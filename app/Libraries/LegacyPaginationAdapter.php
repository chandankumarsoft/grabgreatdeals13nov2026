<?php

namespace App\Libraries;

final class LegacyPaginationAdapter
{
    public function __construct(
        private readonly string $baseUrl,
        private readonly int $totalRows,
        private readonly int $perPage,
        private readonly int $offset,
    ) {
    }

    public function create_links(): string
    {
        if ($this->perPage < 1 || $this->totalRows <= $this->perPage) {
            return '';
        }

        $pageCount   = (int) ceil($this->totalRows / $this->perPage);
        $currentPage = min((int) floor(max(0, $this->offset) / $this->perPage), $pageCount - 1);
        $firstPage   = max(0, $currentPage - 3);
        $lastPage    = min($pageCount - 1, $firstPage + 6);
        $firstPage   = max(0, $lastPage - 6);
        $links       = '<ul class="pagination">';

        if ($currentPage > 0) {
            $links .= $this->link(0, '&laquo;');
        }

        for ($page = $firstPage; $page <= $lastPage; $page++) {
            $offset = $page * $this->perPage;
            $links .= $page === $currentPage
                ? '<li class="active"><a href="#">' . ($page + 1) . '</a></li>'
                : $this->link($offset, (string) ($page + 1));
        }

        if ($currentPage < $pageCount - 1) {
            $links .= $this->link(($pageCount - 1) * $this->perPage, '&raquo;');
        }

        return $links . '</ul>';
    }

    private function link(int $offset, string $label): string
    {
        $separator = str_contains($this->baseUrl, '?') ? '&' : '?';

        return '<li><a href="' . esc($this->baseUrl . $separator . 'page=' . $offset) . '">' . $label . '</a></li>';
    }
}
