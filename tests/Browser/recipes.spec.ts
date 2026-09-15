import { test, expect } from '@playwright/test';

test.use({ reducedMotion: 'reduce' });

for (const width of [390, 1440]) {
    test(`recipes can be discovered, filtered and cooked at ${width}px`, async ({ page }) => {
        await page.setViewportSize({ width, height: 1000 });
        const errors: string[] = [];
        page.on('pageerror', (error) => errors.push(error.message));
        await page.goto('/');
        const hero = page.getByRole('region', { name: 'A taste of Wiener Box' });
        await hero.getByRole('button', { name: 'Show slide 3: Recipes & good ideas' }).click();
        await hero.getByRole('link', { name: 'Get cooking' }).click();

        await expect(page).toHaveURL(/\/recipes$/);
        await expect(page.getByRole('heading', { level: 1 })).toContainText('Make a meal');
        await expect(page.getByRole('region', { name: 'Recipe of the moment' })).toBeVisible();
        await expect(page.locator('.recipe-card')).toHaveCount(6);
        for (const photo of await page.locator('.recipe-photo').all()) {
            await photo.scrollIntoViewIfNeeded();
            await photo.evaluate(async (image) => (image as HTMLImageElement).decode());
        }
        await page.evaluate(() => window.scrollTo(0, 0));
        await page.evaluate(() => document.fonts.ready);
        expect(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth)).toBe(true);
        await page.screenshot({ path: `outputs/implementation/recipes-${width}.png`, fullPage: true });

        const filters = page.getByRole('group', { name: 'Filter recipes' });
        for (const [name, count] of [
            ['Sauces', 2],
            ['Sides', 2],
            ['Sausages', 3],
        ] as const) {
            await filters.getByRole('button', { name, exact: true }).click();
            await expect(filters.getByRole('button', { name, exact: true })).toHaveAttribute(
                'aria-pressed',
                'true',
            );
            await expect(page.locator('.recipe-card')).toHaveCount(count);
            await expect(page.locator('.recipe-result-count')).toHaveText(`${count} recipes to try`);
            await expect(page.locator('.recipe-card .recipe-category')).toHaveText(Array(count).fill(name));
            expect(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth)).toBe(true);
        }
        await filters.getByRole('button', { name: 'All recipes', exact: true }).click();
        await page
            .getByRole('region', { name: 'Recipe of the moment' })
            .getByRole('link', { name: 'Get cooking' })
            .click();

        await expect(page).toHaveURL(/\/recipes\/lemon-mustard-chicken-sausages$/);
        await expect(page.getByRole('heading', { level: 1 })).toContainText('chicken sausage tray bake');
        await expect(page.getByText('60 min total', { exact: true })).toBeVisible();
        await page.locator('.recipe-photo').evaluate(async (image) => (image as HTMLImageElement).decode());
        await page.screenshot({
            path: `outputs/implementation/recipe-chicken-sausages-${width}.png`,
            fullPage: true,
        });
        await page.getByRole('link', { name: 'Let’s make it' }).click();
        await expect(page.locator('#recipe-method')).toBeInViewport();
        const ingredient = page.getByRole('checkbox', { name: /8 fresh chicken sausages/ });
        await ingredient.check();
        await expect(ingredient).toBeChecked();
        await ingredient.uncheck();
        await expect(ingredient).not.toBeChecked();
        expect(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth)).toBe(true);

        await page.getByRole('link', { name: 'All recipes', exact: true }).click();
        await expect(page).toHaveURL(/\/recipes$/);
        await page.getByRole('link', { name: 'Wiener Box home', exact: true }).first().click();
        await expect(page).toHaveURL(/\/$/);
        if (width < 900) {
            await page.getByRole('button', { name: 'Toggle navigation' }).click();
            await page
                .getByRole('navigation', { name: 'Mobile navigation' })
                .getByRole('link', { name: 'Recipes', exact: true })
                .click();
            await expect(page.getByRole('navigation', { name: 'Mobile navigation' })).toHaveCount(0);
        } else {
            await page
                .getByRole('navigation', { name: 'Main navigation' })
                .getByRole('link', { name: 'Recipes', exact: true })
                .click();
        }
        await expect(page).toHaveURL(/\/recipes$/);
        expect(errors).toEqual([]);
    });
}

test('all seven seeded recipe links have full methods and working food photos', async ({ page }) => {
    await page.goto('/recipes');
    const urls = await page
        .locator('main a[href^="/recipes/"]')
        .evaluateAll((links) => [...new Set(links.map((link) => link.getAttribute('href')!))]);
    expect(urls).toHaveLength(7);
    for (const url of urls) {
        await page.goto(url);
        await expect(page.getByRole('heading', { level: 1 })).toBeVisible();
        expect(await page.getByRole('checkbox').count()).toBeGreaterThan(4);
        expect(await page.locator('.recipe-method ol li').count()).toBeGreaterThan(2);
        await page.locator('.recipe-photo').evaluate(async (image) => (image as HTMLImageElement).decode());
        await expect(page.locator('link[rel="canonical"]')).toHaveAttribute('href', new RegExp(`${url}$`));
    }
});

test('recipe navigation and layout fit a compact desktop viewport', async ({ page }) => {
    await page.setViewportSize({ width: 920, height: 1000 });
    await page.goto('/recipes');
    const navigation = page.getByRole('navigation', { name: 'Main navigation' });
    await expect(navigation.getByRole('link', { name: 'Recipes', exact: true })).toBeVisible();
    const navigationBounds = (await navigation.boundingBox())!;
    const actionsBounds = (await page.locator('.header-actions').boundingBox())!;
    expect(navigationBounds.x + navigationBounds.width).toBeLessThanOrEqual(actionsBounds.x);
    expect(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth)).toBe(true);
});
