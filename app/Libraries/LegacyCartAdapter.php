<?php

namespace App\Libraries;

final class LegacyCartAdapter
{
    public function __construct(private readonly LegacySessionAdapter $session)
    {
    }

    public function insert(array $item): string|false
    {
        if (
            ! isset($item['id'], $item['qty'], $item['price'], $item['name'])
            || ! is_numeric($item['qty'])
            || ! is_numeric($item['price'])
            || (int) $item['qty'] < 1
            || (float) $item['price'] < 0
        ) {
            return false;
        }

        $item['options'] = is_array($item['options'] ?? null) ? $item['options'] : [];
        $rowId = md5((string) $item['id'] . serialize($item['options']));
        $contents = $this->storedContents();

        if (isset($contents[$rowId])) {
            $item['qty'] = (int) $contents[$rowId]['qty'] + (int) $item['qty'];
            $item = array_replace($contents[$rowId], $item);
        }

        $item['qty'] = (int) $item['qty'];
        $item['price'] = (float) $item['price'];
        $item['rowid'] = $rowId;
        $item['subtotal'] = $item['price'] * $item['qty'];
        $contents[$rowId] = $item;
        $this->saveContents($contents);

        return $rowId;
    }

    public function update(array $item): bool
    {
        $rowId = (string) ($item['rowid'] ?? '');
        $contents = $this->storedContents();

        if ($rowId === '' || ! isset($contents[$rowId])) {
            return false;
        }

        if (array_key_exists('qty', $item)) {
            if (! is_numeric($item['qty']) || (int) $item['qty'] < 0) {
                return false;
            }

            if ((int) $item['qty'] === 0) {
                unset($contents[$rowId]);
                $this->saveContents($contents);

                return true;
            }

            $contents[$rowId]['qty'] = (int) $item['qty'];
        }

        foreach ($item as $key => $value) {
            if (! in_array($key, ['rowid', 'qty', 'subtotal'], true)) {
                $contents[$rowId][$key] = $value;
            }
        }

        $contents[$rowId]['subtotal'] = (float) $contents[$rowId]['price'] * (int) $contents[$rowId]['qty'];
        $this->saveContents($contents);

        return true;
    }

    public function contents(): array
    {
        $contents = $this->session->userdata('cart_contents');

        if (! is_array($contents)) {
            return [];
        }

        unset($contents['cart_total'], $contents['total_items']);

        return array_values(array_filter($contents, 'is_array'));
    }

    public function total_items(): int
    {
        $contents = $this->session->userdata('cart_contents');

        if (is_array($contents) && isset($contents['total_items'])) {
            return (int) $contents['total_items'];
        }

        return array_sum(array_map(
            static fn (array $item): int => (int) ($item['qty'] ?? 0),
            $this->contents(),
        ));
    }

    public function total(): float
    {
        $contents = $this->session->userdata('cart_contents');

        if (is_array($contents) && isset($contents['cart_total'])) {
            return (float) $contents['cart_total'];
        }

        return array_sum(array_map(
            static fn (array $item): float => (float) ($item['subtotal'] ?? ((float) ($item['price'] ?? 0) * (int) ($item['qty'] ?? 0))),
            $this->contents(),
        ));
    }

    /**
     * @return array<string, mixed>
     */
    private function storedContents(): array
    {
        $contents = $this->session->userdata('cart_contents');

        if (! is_array($contents)) {
            return [];
        }

        unset($contents['cart_total'], $contents['total_items']);

        return array_filter($contents, 'is_array');
    }

    /**
     * @param array<string, array<string, mixed>> $contents
     */
    private function saveContents(array $contents): void
    {
        $total = 0.0;
        $items = 0;

        foreach ($contents as &$item) {
            $item['subtotal'] = (float) $item['price'] * (int) $item['qty'];
            $total += $item['subtotal'];
            $items += (int) $item['qty'];
        }
        unset($item);

        if ($contents === []) {
            $this->session->unset_userdata('cart_contents');

            return;
        }

        $contents['cart_total'] = $total;
        $contents['total_items'] = $items;
        $this->session->set_userdata('cart_contents', $contents);
    }
}
