# Filament HR System

Filament HR System is a Laravel package designed to streamline HR management tasks. It integrates seamlessly with Laravel, Livewire, and Filament to provide prebuilt widgets, migrations, and customizable assets.

---

## Features

- Attendance management widgets.
- Prebuilt Blade views.
- Easy migration setup.
- Customizable Tailwind CSS assets.
- Fully compatible with Filament.

---

## Installation

To install the package, follow these steps:

1. Add the package to your project using Composer:

   ```bash
   composer require namratalohani/filament-hr-system
   ```

2. Publish the package assets and configuration:

   ```bash
   php artisan vendor:publish --tag=config
   ```

   This creates a configuration file in your project: `config/filament-hr-system.php`.

---

## Setting Up the Package

### Step 1: Publish Migrations

To add the package's migrations to your project, run:

```bash
php artisan vendor:publish --tag=migrations
```

Then apply the migrations to your database:

```bash
php artisan migrate
```

---

### Step 2: Publish Blade Views

If you want to customize the Blade views provided by the package, publish them using:

```bash
php artisan vendor:publish --tag=views
```

This will copy the views to `resources/views/vendor/filament-hr-system`.

---

### Step 3: Update Tailwind CSS Configuration

To ensure the package's Blade files are processed correctly by Tailwind CSS, you need to update your `tailwind.config.js` file.

1. Add the following path to the `content` section in your **main Tailwind configuration file**:

   ```js
   module.exports = {
       content: [
           "./resources/**/*.blade.php",
           "./vendor/namratalohani/**/*.blade.php",
           // other paths...
       ],
       theme: {
           extend: {},
       },
       plugins: [],
   };
   ```

2. If you are using Filament, update **Filament's Tailwind configuration file** (usually located at `filament/admin/tailwind.config.js`):

   ```js
   module.exports = {
       content: [
           "./resources/**/*.blade.php",
           "./vendor/filament/**/*.blade.php",
           "./vendor/namratalohani/**/*.blade.php",
           // other paths...
       ],
       theme: {
           extend: {},
       },
       plugins: [],
   };
   ```

3. Rebuild your frontend assets:
   ```bash
   npm run build
   ```

---

### Step 4: Register the Widget

To register the `AttendanceWidget` in your **Filament admin panel**, modify your `AdminPanelProvider`:

1. Locate your `AdminPanelProvider` file, usually in `app/Providers/Filament/AdminPanelProvider.php`.

2. Add the `AttendanceWidget` to the `widgets` section:

   ```php
   use Namratalohani\FilamentHrSystem\Filament\Widgets\AttendanceWidget;

   class AdminPanelProvider extends PanelProvider
   {
       public function panel(Panel $panel): Panel
       {
           return $panel
               ->default()
               ->id('admin')
               ->path('admin')
               ->login()
               ->viteTheme('resources/css/filament/admin/theme.css')
               ->widgets([
                   AttendanceWidget::class,
               ]);
       }
   }
   ```

3. Save the changes, and your widget will now be available in the Filament admin panel.

---

## Customization

### Step 1: Customize Assets

If you need to customize the package's CSS or JS, you can publish the assets:

```bash
php artisan vendor:publish --tag=assets
```

The assets will be copied to the `public/vendor/filament-hr-system` directory. Modify them as needed.

---

## Example Project Setup

If you’re cloning the repository:

1. Clone the repository:
   ```bash
   git clone https://github.com/namratalohani/filament-hr-system.git
   ```

2. Navigate to the package directory:
   ```bash
   cd filament-hr-system
   ```

3. Install dependencies:
   ```bash
   composer install
   ```

4. Link the package to your project (if working locally):
   ```bash
   composer require path/to/your/package
   ```

5. Follow the installation steps above to configure the package.

---

## Troubleshooting

### Issue: "No publishable resources for tag"

If you encounter an error like:
```text
No publishable resources for tag [tag-name].
```

Ensure the package service provider is properly registered in your Laravel project. Check `config/app.php` or verify that the `extra` section in your `composer.json` includes:

```json
"extra": {
    "laravel": {
        "providers": [
            "Namratalohani\\FilamentHrSystem\\FilamentHrSystemServiceProvider"
        ]
    }
}
```

---

## Contributing

Contributions are welcome! Please feel free to open issues or submit pull requests.

---

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).
