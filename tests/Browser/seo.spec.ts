import { expect, test } from '@playwright/test';

test.describe('server-rendered storefront', () => {
    test.use({ javaScriptEnabled: false });

    test('public content and product links are readable without JavaScript', async ({ page }) => {
        await page.goto('/');
        await expect(page.locator('h1')).toContainText('WURST.');
        await expect(page.locator('head title')).toHaveCount(1);
        await expect(
            page.getByRole('link', { name: 'Explore The Big Wiener Club', exact: true }),
        ).toBeVisible();
        await expect(page.locator('head meta[name="description"]')).toHaveCount(1);
        await expect(page.locator('head link[rel="canonical"]')).toHaveCount(1);

        await page.goto('/shop');
        await expect(page.locator('.product-card')).toHaveCount(6);
        await page.getByRole('link', { name: 'Explore Bratwurst', exact: true }).click();
        await expect(page.locator('h1')).toHaveText('Bratwurst.');
        await expect(page.locator('.detail-description')).not.toBeEmpty();
        await expect(page.getByRole('navigation', { name: 'Breadcrumb' })).toContainText('Bratwurst');
        await expect(page.locator('head link[rel="canonical"]')).toHaveAttribute(
            'href',
            /\/products\/bratwurst$/,
        );
        const data = JSON.parse(await page.locator('head script[type="application/ld+json"]').innerText());
        expect(data['@graph'].find((item: { '@type': string }) => item['@type'] === 'Product').name).toBe(
            'Bratwurst',
        );
    });
});

test('hydration and Inertia navigation keep one current set of metadata', async ({ page }) => {
    const errors: string[] = [];
    page.on('pageerror', (error) => errors.push(error.message));
    page.on('console', (message) => {
        if (/hydration/i.test(message.text())) errors.push(message.text());
    });
    await page.goto('/shop?utm_source=seo-test');
    await expect(page).toHaveTitle('Sausage Boxes, Subscriptions & Gifts | Wiener Box');
    await page.getByRole('link', { name: 'Explore Bratwurst', exact: true }).click();
    await expect(page).toHaveTitle('Bratwurst | German-Style Sausages | Wiener Box');
    await expect(page.locator('head meta[property="og:image"]')).toHaveAttribute(
        'content',
        /bratwurst-reference\.webp$/,
    );
    await expect(page.locator('head link[rel="canonical"]')).toHaveAttribute(
        'href',
        /\/products\/bratwurst$/,
    );
    await expect(page.locator('head title')).toHaveCount(1);
    await expect(page.locator('head meta[name="description"]')).toHaveCount(1);
    await expect(page.locator('head meta[name="robots"]')).toHaveCount(1);
    await expect(page.locator('head script[type="application/ld+json"]')).toHaveCount(1);

    await page.getByRole('link', { name: /^Your box,/ }).click();
    await expect(page).toHaveTitle('Your Box | Wiener Box');
    await expect(page.locator('head meta[name="robots"]')).toHaveAttribute('content', /noindex/);
    await expect(page.locator('head link[rel="canonical"]')).toHaveCount(0);
    await expect(page.locator('head script[type="application/ld+json"]')).toHaveCount(0);

    await page.goBack();
    await expect(page).toHaveTitle('Bratwurst | German-Style Sausages | Wiener Box');
    await expect(page.locator('head link[rel="canonical"]')).toHaveCount(1);
    await expect(page.locator('head script[type="application/ld+json"]')).toHaveCount(1);
    expect(errors).toEqual([]);
});
