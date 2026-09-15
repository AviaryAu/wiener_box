import { defineConfig } from '@playwright/test';
export default defineConfig({
    testDir: './tests/Browser',
    fullyParallel: false,
    workers: 1,
    use: {
        baseURL: process.env.PREVIEW_URL ?? 'http://127.0.0.1:8000',
        headless: true,
        launchOptions: process.env.PLAYWRIGHT_CHROMIUM_EXECUTABLE
            ? { executablePath: process.env.PLAYWRIGHT_CHROMIUM_EXECUTABLE }
            : {},
        screenshot: 'only-on-failure',
        trace: 'retain-on-failure',
    },
    reporter: 'list',
});
