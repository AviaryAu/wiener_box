import { test, expect } from '@playwright/test';

for (const width of [320, 390, 768, 1440]) {
    test(`home is usable at ${width}px`, async ({ page }) => {
        const errors: string[] = [];
        page.on('pageerror', (error) => errors.push(error.message));
        await page.setViewportSize({ width, height: 960 });
        await page.goto('/');
        await expect(page.getByRole('heading', { level: 1 })).toContainText('WURST.');
        await page.evaluate(() => document.fonts.ready);
        await expect(page.locator('.product-card')).toHaveCount(3);
        expect(await page.evaluate(() => document.documentElement.scrollWidth <= window.innerWidth)).toBe(
            true,
        );
        await page.locator('img').evaluateAll(async (images) =>
            Promise.all(
                images.map((image) => {
                    const img = image as HTMLImageElement;
                    img.loading = 'eager';
                    return img.decode();
                }),
            ),
        );
        expect(
            await page
                .locator('img')
                .evaluateAll((images) =>
                    images.every(
                        (image) =>
                            (image as HTMLImageElement).complete &&
                            (image as HTMLImageElement).naturalWidth > 0,
                    ),
                ),
        ).toBe(true);
        await page.keyboard.press('Tab');
        await expect(page.getByRole('link', { name: 'Skip to content' })).toBeFocused();
        await page.getByRole('link', { name: 'Skip to content' }).blur();
        if (width === 390 || width === 1440) {
            await page.screenshot({ path: `outputs/implementation/home-${width}.png`, fullPage: true });
            await page.locator('.hero').screenshot({ path: `outputs/implementation/hero-${width}.png` });
        }
        if (width < 900) {
            await page.getByRole('button', { name: 'Toggle navigation' }).click();
            await expect(page.getByRole('navigation', { name: 'Mobile navigation' })).toBeVisible();
        }
        expect(errors).toEqual([]);
    });
}

test('guest can filter, inspect a product, add, update and remove', async ({ page }) => {
    const errors: string[] = [];
    page.on('pageerror', (error) => errors.push(error.message));
    await page.goto('/shop');
    await page.getByRole('button', { name: 'Individual packs', exact: true }).click();
    await expect(page.locator('.product-card')).toHaveCount(3);
    await page.getByRole('textbox', { name: 'Search products' }).fill('brat');
    await expect(page.locator('.product-card')).toHaveCount(1);
    await page.getByRole('link', { name: 'Explore Bratwurst', exact: true }).click();
    await expect(page.getByRole('heading', { level: 1 })).toContainText('Bratwurst');
    await expect(page.locator('.detail-art .food-photo')).toBeVisible();
    await page.locator('.detail-art img').evaluate((image: HTMLImageElement) => image.decode());
    await page.screenshot({ path: 'outputs/implementation/bratwurst.png', fullPage: true });
    await page.getByRole('button', { name: 'Add to your box' }).click();
    await expect(page.getByRole('status')).toContainText('Added to your box');
    await page.goto('/cart');
    await expect(page.locator('.cart-line')).toHaveCount(1);
    await expect(page.locator('.cart-thumb .food-photo')).toBeVisible();
    await expect(page.locator('.cart-summary')).toContainText('$20.90');
    await page.getByRole('button', { name: 'Increase Bratwurst quantity' }).click();
    await expect(page.locator('.cart-summary')).toContainText('$29.80');
    await page.reload();
    await expect(page.locator('.cart-summary')).toContainText('$29.80');
    await page.screenshot({ path: 'outputs/implementation/cart.png', fullPage: true });
    await page.getByRole('button', { name: 'Remove', exact: true }).click();
    await expect(page.getByText('A little empty. A lot of potential.')).toBeVisible();
    await page.goto('/shop?category=pack');
    await expect(page.locator('.product-art .food-photo')).toHaveCount(3);
    await page
        .locator('.food-photo')
        .evaluateAll(async (images) =>
            Promise.all(images.map((image) => (image as HTMLImageElement).decode())),
        );
    await page.screenshot({ path: 'outputs/implementation/sausage-range.png', fullPage: true });
    await page.goto('/products/the-regular');
    await expect(page.locator('.gallery-main-photo')).toHaveAttribute('src', /regular-open-box/);
    await expect(page.locator('.gallery-thumbnails button')).toHaveCount(5);
    await page.locator('.gallery-main-photo').evaluate((image: HTMLImageElement) => image.decode());
    await page.screenshot({ path: 'outputs/implementation/box-detail.png', fullPage: true });
    expect(errors).toEqual([]);
});

test('every product has working gallery images and the viewer supports keyboard navigation', async ({
    page,
}) => {
    const products = [
        ['the-regular', 5],
        ['the-fling', 5],
        ['the-big-gesture', 5],
        ['classic-wieners', 2],
        ['bratwurst', 2],
        ['cheese-kransky', 2],
    ] as const;
    for (const [slug, count] of products) {
        await page.goto(`/products/${slug}`);
        const thumbnails = page.locator('.gallery-thumbnails button');
        await expect(thumbnails).toHaveCount(count);
        await page
            .locator('.product-gallery img')
            .evaluateAll(async (images) =>
                Promise.all(images.map((image) => (image as HTMLImageElement).decode())),
            );
        const firstSource = await page.locator('.gallery-main-photo').getAttribute('src');
        await thumbnails.nth(1).click();
        await expect(thumbnails.nth(1)).toHaveAttribute('aria-pressed', 'true');
        await expect(page.locator('.gallery-main-photo')).not.toHaveAttribute('src', firstSource!);
        await page.keyboard.press('End');
        await expect(thumbnails.last()).toBeFocused();
        await expect(thumbnails.last()).toHaveAttribute('aria-pressed', 'true');
        await page.keyboard.press('ArrowRight');
        await expect(thumbnails.first()).toHaveAttribute('aria-pressed', 'true');
        await expect(page.locator('.gallery-main-photo')).toHaveAttribute('src', firstSource!);
    }

    await page.goto('/products/the-regular');
    const opener = page.locator('.gallery-image-button');
    const originalOverflow = await page.evaluate(() => document.body.style.overflow);
    await opener.click();
    const dialog = page.getByRole('dialog', { name: 'The Regular photo viewer' });
    await expect(dialog).toBeVisible();
    await expect(dialog.getByRole('button', { name: 'Close photo viewer' })).toBeFocused();
    await page.keyboard.press('Shift+Tab');
    await expect(dialog.getByRole('button', { name: 'Next photo' })).toBeFocused();
    await page.keyboard.press('Tab');
    await expect(dialog.getByRole('button', { name: 'Close photo viewer' })).toBeFocused();
    await page.keyboard.press('ArrowRight');
    await expect(dialog.locator('.gallery-position')).toContainText('2 / 5');
    await expect(dialog.locator('img')).toHaveAttribute('src', /classic-wieners-reference/);
    await page.keyboard.press('Home');
    await dialog.locator('img').evaluate((image: HTMLImageElement) => image.decode());
    await page.screenshot({ path: 'outputs/implementation/product-gallery-viewer.png', fullPage: false });
    await page.keyboard.press('Escape');
    await expect(dialog).not.toBeVisible();
    await expect(opener).toBeFocused();
    expect(await page.evaluate(() => document.body.style.overflow)).toBe(originalOverflow);

    await page.goto('/shop');
    await page.getByRole('link', { name: 'Explore The Regular', exact: true }).click();
    await page.locator('.gallery-image-button').click();
    await page.goBack();
    await expect(page).toHaveURL(/\/shop$/);
    expect(await page.evaluate(() => document.body.style.overflow)).toBe(originalOverflow);
});

test.describe('touch product gallery', () => {
    test.use({ viewport: { width: 390, height: 844 }, hasTouch: true });
    test('mobile thumbnails, swipe and large photos are usable without overflow', async ({ page }) => {
        await page.goto('/products/the-big-gesture');
        await page.locator('.gallery-thumbnails button').nth(2).tap();
        await expect(page.locator('.gallery-main-photo')).toHaveAttribute('src', /bratwurst-reference/);
        await page.locator('.gallery-thumbnails button').first().tap();
        const stage = page.locator('.gallery-stage');
        await stage.scrollIntoViewIfNeeded();
        await stage.evaluate((element) => {
            const box = element.getBoundingClientRect();
            const makeTouch = (x: number) =>
                new Touch({ identifier: 1, target: element, clientX: x, clientY: box.y + 100 });
            element.dispatchEvent(
                new TouchEvent('touchstart', { bubbles: true, touches: [makeTouch(box.x + 200)] }),
            );
            element.dispatchEvent(
                new TouchEvent('touchend', {
                    bubbles: true,
                    cancelable: true,
                    changedTouches: [makeTouch(box.x + 80)],
                }),
            );
        });
        await expect(page.locator('.gallery-main-photo')).toHaveAttribute('src', /classic-wieners-reference/);
        await expect(page.getByRole('dialog')).not.toBeVisible();
        await page.locator('.gallery-image-button').tap();
        const dialog = page.getByRole('dialog');
        await expect(dialog).toBeVisible();
        await dialog.getByRole('button', { name: 'Next photo' }).tap();
        await expect(dialog.locator('.gallery-position')).toContainText('3 / 5');
        expect(await dialog.evaluate((element) => element.scrollWidth <= element.clientWidth)).toBe(true);
        await dialog.getByRole('button', { name: 'Close photo viewer' }).tap();
        await expect(dialog).not.toBeVisible();
        await page.locator('.gallery-thumbnails button').first().tap();
        await page.locator('.gallery-main-photo').evaluate((image: HTMLImageElement) => image.decode());
        expect(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth)).toBe(true);
        await page.screenshot({ path: 'outputs/implementation/product-gallery-mobile.png', fullPage: true });
    });
});

test('postcode check and account entry work on mobile', async ({ page }) => {
    await page.setViewportSize({ width: 390, height: 844 });
    await page.goto('/delivery');
    await page.getByLabel('Your postcode', { exact: true }).fill('2000');
    await page.getByRole('button', { name: 'Check postcode' }).click();
    await expect(page.getByRole('status')).toContainText('Sydney: on our proposed route.');
    await page.goto('/account');
    await expect(page).toHaveURL(/\/login$/);
    await expect(page.getByRole('button', { name: 'Sign in', exact: true })).toBeVisible();
    await page.getByRole('link', { name: 'Create an account', exact: true }).click();
    await expect(page.getByLabel('Confirm password', { exact: true })).toBeVisible();
    expect(await page.evaluate(() => document.documentElement.scrollWidth <= window.innerWidth)).toBe(true);
});

test('local owner can sign in and review native commerce admin', async ({ page }) => {
    const { readFileSync, existsSync } = await import('node:fs');
    const path = 'storage/app/private/preview-admin.json';
    test.skip(!existsSync(path), 'Run php artisan wiener:preview-admin for the optional local admin check.');
    const credentials = JSON.parse(readFileSync(path, 'utf8'));
    await page.goto('/admin/login');
    await page.locator('input[type="email"]').fill(credentials.email);
    await page.getByRole('textbox', { name: /^Password/ }).fill(credentials.password);
    await page.getByRole('button', { name: 'Sign in', exact: true }).click();
    await expect(page).toHaveURL(/\/admin$/);
    await expect(page.getByRole('heading', { name: 'Dashboard', exact: true })).toBeVisible();
    await expect(page.getByText('Orders today', { exact: true })).toBeVisible({ timeout: 15000 });
    await page.setViewportSize({ width: 1440, height: 1000 });
    await page.screenshot({ path: 'outputs/implementation/admin.png', fullPage: true });
    await page.goto('/admin/product-listings');
    await expect(page.getByText('the-regular', { exact: true }).first()).toBeVisible();
    await page.goto('/admin/delivery-areas');
    await expect(page.getByText('2000', { exact: true }).first()).toBeVisible();
});
