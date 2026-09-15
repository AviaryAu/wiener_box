import { test, expect } from '@playwright/test';

for (const width of [320, 390, 768, 1440]) {
    test(`hero slideshow changes copy and artwork without shifting the page at ${width}px`, async ({
        page,
    }) => {
        await page.emulateMedia({ reducedMotion: 'reduce' });
        await page.setViewportSize({ width, height: 1000 });
        const errors: string[] = [];
        page.on('pageerror', (error) => errors.push(error.message));
        await page.goto('/');
        const hero = page.getByRole('region', { name: 'A taste of Wiener Box' });
        const firstMarker = hero.getByRole('button', { name: 'Show slide 1: The good stuff' });
        const clubMarker = hero.getByRole('button', { name: 'Show slide 2: The Big Wiener Club' });
        const recipeMarker = hero.getByRole('button', { name: 'Show slide 3: Recipes & good ideas' });
        await expect(hero.getByRole('heading', { level: 1 })).toContainText('WURST.');
        await page.evaluate(() => document.fonts.ready);
        await hero
            .locator('img')
            .evaluateAll(async (images) =>
                Promise.all(images.map((image) => (image as HTMLImageElement).decode())),
            );
        const originalHeight = (await hero.boundingBox())!.height;
        if (width === 390 || width === 1440) {
            await hero.screenshot({ path: `outputs/implementation/slideshow-original-${width}.png` });
        }

        await clubMarker.click();

        await expect(clubMarker).toHaveAttribute('aria-pressed', 'true');
        await expect(firstMarker).toHaveAttribute('aria-pressed', 'false');
        await expect(hero.getByRole('heading', { name: /JOIN THE.*BIG WIENER.*CLUB/ })).toBeVisible();
        await expect(hero.getByRole('heading', { level: 1 })).toHaveCount(0);
        await expect(hero.getByRole('img', { name: /membership card/ })).toBeVisible();
        await expect(hero.getByRole('link', { name: 'Find your box' })).toHaveCount(0);
        expect((await hero.boundingBox())!.height).toBeCloseTo(originalHeight, 0);
        expect(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth)).toBe(true);
        const artwork = (await hero.locator('#hero-slide-2 .hero-club-art').boundingBox())!;
        const controls = (await hero.locator('.hero-controls').boundingBox())!;
        expect(controls.y).toBeGreaterThanOrEqual(artwork.y + artwork.height);
        if (width === 390 || width === 1440) {
            await hero.screenshot({ path: `outputs/implementation/slideshow-club-${width}.png` });
        }

        await page.keyboard.press('ArrowRight');
        await expect(recipeMarker).toBeFocused();
        await expect(recipeMarker).toHaveAttribute('aria-pressed', 'true');
        await expect(hero.getByRole('heading', { name: 'Wiener, Wiener, Chicken Dinner' })).toBeVisible();
        await expect(hero.getByRole('img', { name: /chicken costume/ })).toBeVisible();
        expect((await hero.boundingBox())!.height).toBeCloseTo(originalHeight, 0);
        expect(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth)).toBe(true);
        if (width === 390 || width === 1440) {
            await hero.screenshot({ path: `outputs/implementation/slideshow-recipes-${width}.png` });
        }
        await page.keyboard.press('Home');
        await expect(firstMarker).toBeFocused();
        await expect(firstMarker).toHaveAttribute('aria-pressed', 'true');
        await page.keyboard.press('End');
        await expect(recipeMarker).toBeFocused();
        await expect(recipeMarker).toHaveAttribute('aria-pressed', 'true');
        await hero.getByRole('button', { name: 'Next slide', exact: true }).click();
        await expect(firstMarker).toHaveAttribute('aria-pressed', 'true');
        await hero.getByRole('button', { name: 'Previous slide', exact: true }).click();
        await expect(recipeMarker).toHaveAttribute('aria-pressed', 'true');

        await clubMarker.click();
        await hero.getByRole('link', { name: 'Get on the list' }).click();
        await expect(page).toHaveURL(/#launch-list$/);
        await expect(page.getByLabel('Email address', { exact: true })).toBeInViewport();
        expect(errors).toEqual([]);
    });
}

test('slideshow rotates automatically and pauses for hover, its pause control and keyboard focus', async ({
    page,
}) => {
    await page.emulateMedia({ reducedMotion: 'no-preference' });
    await page.clock.install();
    await page.goto('/');
    const hero = page.getByRole('region', { name: 'A taste of Wiener Box' });
    const stage = hero.locator('.hero-stage');
    const firstMarker = hero.getByRole('button', { name: 'Show slide 1: The good stuff' });
    const clubMarker = hero.getByRole('button', { name: 'Show slide 2: The Big Wiener Club' });
    const recipeMarker = hero.getByRole('button', { name: 'Show slide 3: Recipes & good ideas' });
    await expect(stage).toHaveAttribute('aria-live', 'off');

    await page.clock.fastForward(8100);
    await expect(clubMarker).toHaveAttribute('aria-pressed', 'true');
    await hero.getByRole('heading', { name: /JOIN THE/ }).hover();
    await expect(stage).toHaveAttribute('aria-live', 'polite');
    await page.clock.fastForward(16000);
    await expect(clubMarker).toHaveAttribute('aria-pressed', 'true');

    await page.mouse.move(0, 0);
    await expect(stage).toHaveAttribute('aria-live', 'off');
    await page.clock.fastForward(8100);
    await expect(recipeMarker).toHaveAttribute('aria-pressed', 'true');
    await hero.getByRole('button', { name: 'Pause slideshow' }).click();
    await page.mouse.move(0, 0);
    await page.clock.fastForward(16000);
    await expect(recipeMarker).toHaveAttribute('aria-pressed', 'true');
    await expect(hero.getByRole('button', { name: 'Play slideshow' })).toBeVisible();

    await hero.getByRole('button', { name: 'Play slideshow' }).click();
    await page.mouse.move(0, 0);
    await expect(stage).toHaveAttribute('aria-live', 'off');
    await page.clock.fastForward(8100);
    await expect(firstMarker).toHaveAttribute('aria-pressed', 'true');
    await hero.getByRole('link', { name: 'Find your box' }).focus();
    await page.clock.fastForward(16000);
    await expect(firstMarker).toHaveAttribute('aria-pressed', 'true');
    await expect(hero.getByRole('link', { name: 'Find your box' })).toBeFocused();
});

test('reduced motion starts paused and the club product link opens the existing product', async ({
    page,
}) => {
    await page.emulateMedia({ reducedMotion: 'reduce' });
    await page.clock.install();
    await page.goto('/');
    const hero = page.getByRole('region', { name: 'A taste of Wiener Box' });
    await expect(hero.getByRole('button', { name: 'Play slideshow' })).toBeVisible();

    await page.clock.fastForward(20000);

    await expect(hero.getByRole('heading', { level: 1 })).toContainText('WURST.');
    await hero.getByRole('button', { name: 'Next slide', exact: true }).click();
    await hero.getByRole('link', { name: 'Inspect the package' }).click();
    await expect(page).toHaveURL(/\/products\/the-regular$/);
    await expect(page.getByRole('heading', { level: 1 })).toHaveText('The Big Wiener Club.');
    await page.goBack();
    await expect(hero.getByRole('heading', { level: 1 })).toContainText('WURST.');
});

test.describe('touch hero slideshow', () => {
    test.use({ viewport: { width: 390, height: 844 }, hasTouch: true, reducedMotion: 'reduce' });

    test('horizontal swipes change banners while vertical swipes keep the current banner', async ({
        page,
    }) => {
        await page.goto('/');
        const hero = page.getByRole('region', { name: 'A taste of Wiener Box' });
        const stage = hero.locator('.hero-stage');
        const swipe = async (dx: number, dy: number) => {
            await stage.evaluate(
                (element, movement) => {
                    const makeTouch = (x: number, y: number) =>
                        new Touch({ identifier: 1, target: element, clientX: x, clientY: y });
                    element.dispatchEvent(
                        new TouchEvent('touchstart', {
                            bubbles: true,
                            touches: [makeTouch(200, 400)],
                        }),
                    );
                    element.dispatchEvent(
                        new TouchEvent('touchend', {
                            bubbles: true,
                            changedTouches: [makeTouch(200 + movement.dx, 400 + movement.dy)],
                        }),
                    );
                },
                { dx, dy },
            );
        };

        await swipe(0, -160);
        await expect(hero.getByRole('heading', { level: 1 })).toContainText('WURST.');
        await swipe(-140, 10);
        await expect(hero.getByRole('heading', { name: /JOIN THE/ })).toBeVisible();
        await swipe(-140, 10);
        await expect(hero.getByRole('heading', { name: 'Wiener, Wiener, Chicken Dinner' })).toBeVisible();
        await swipe(140, 10);
        await expect(hero.getByRole('heading', { name: /JOIN THE/ })).toBeVisible();
        await swipe(140, 10);
        await expect(hero.getByRole('heading', { level: 1 })).toContainText('WURST.');
    });
});
