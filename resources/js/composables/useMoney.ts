const formatter = new Intl.NumberFormat('id-ID', {
    maximumFractionDigits: 0,
});

export function useMoney() {
    const format = (amount: number | null | undefined): string => `Rp ${formatter.format(amount ?? 0)}`;

    return { format };
}
