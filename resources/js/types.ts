export interface Product {
    id: number;
    slug: string;
    name: string;
    description: string;
    price: number | null;
    category: 'subscription' | 'box' | 'gift' | 'pack';
    colour: string;
    cadence: string;
    eyebrow: string;
    story: string;
    contents: string[];
    highlights: string[];
    featured: boolean;
}
export interface CartLine {
    id: number;
    name: string;
    slug: string | null;
    cadence: string;
    colour: string;
    quantity: number;
    unitPrice: number;
    total: number;
    available: boolean;
}
export interface SharedProps {
    [key: string]: unknown;
    auth: { user: { id: number; name: string; email: string } | null };
    cart: { lines: CartLine[]; quantity: number; subtotal: number; deliveryEstimate: number };
    flash: { message?: string };
    launchMode: boolean;
    errors: Record<string, string>;
}
export const money = (cents: number | null) =>
    cents === null
        ? 'Price pending'
        : new Intl.NumberFormat('en-AU', {
              style: 'currency',
              currency: 'AUD',
              minimumFractionDigits: cents % 100 ? 2 : 0,
          }).format(cents / 100);
