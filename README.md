# Voiture.tn E-Commerce Platform

A modern, feature-rich e-commerce platform built with Laravel, Livewire, and Tailwind CSS. This application provides a seamless shopping experience with real-time interactions, responsive design, and a comprehensive admin dashboard.

![Voiture.tn E-Commerce](https://via.placeholder.com/1200x600?text=Voiture.tn+E-Commerce)

## Features

### Customer-Facing Features
- **Responsive Design**: Fully responsive layout that works on all devices
- **Product Catalog**: Browse products with filtering by category, brand, price, and status
- **Product Search**: Search functionality with real-time results
- **User Authentication**: Secure registration and login system
- **Shopping Cart**: Real-time cart management with Livewire
- **Checkout Process**: Streamlined checkout with address management
- **Order Tracking**: Track order status and history
- **User Profiles**: Manage personal information and preferences

### Admin Features
- **Dashboard**: Comprehensive admin dashboard with key metrics
- **Product Management**: Add, edit, and delete products
- **Category & Brand Management**: Organize products effectively
- **Order Management**: Process and track orders
- **User Management**: Manage customer accounts
- **Content Management**: Update site content and banners
- **Analytics**: View sales reports and customer insights

## Tech Stack

- **Backend**: Laravel 10
- **Frontend**: Livewire, Alpine.js, Tailwind CSS
- **Database**: MySQL
- **Authentication**: Laravel Breeze
- **Admin Panel**: Filament
- **Payment Processing**: Stripe integration
- **Image Storage**: Laravel Storage with public disk

## Requirements

- PHP 8.1 or higher
- Composer
- Node.js and NPM
- MySQL 5.7 or higher
- Laravel CLI

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/voiture-ecommerce.git
   cd voiture-ecommerce
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install NPM dependencies**
   ```bash
   npm install
   ```

4. **Create environment file**
   ```bash
   cp .env.example .env
   ```

5. **Generate application key**
   ```bash
   php artisan key:generate
   ```

6. **Configure database in .env file**
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=voiture_ecommerce
   DB_USERNAME=root
   DB_PASSWORD=
   ```

7. **Run database migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```

8. **Create storage link**
   ```bash
   php artisan storage:link
   ```

9. **Build assets**
   ```bash
   npm run build
   ```

10. **Start the development server**
    ```bash
    php artisan serve
    ```

11. **Access the application**
    - Main site: [http://localhost:8000](http://localhost:8000)
    - Admin panel: [http://localhost:8000/admin](http://localhost:8000/admin)

## Demo Accounts

After running the seeders, you can use these demo accounts:

- **Admin Account**
  - Email: admin@example.com
  - Password: password

- **Customer Account**
  - Email: test@example.com
  - Password: password

## Development

### Compiling Assets

- **Development mode**
  ```bash
  npm run dev
  ```

- **Production build**
  ```bash
  npm run build
  ```

### Running Tests

```bash
php artisan test
```

### Performance Testing

```bash
php artisan test:performance --report
```

### Database Optimization

```bash
php artisan optimize:performance
```

## Project Structure

- **app/Http/Livewire**: Contains all Livewire components
- **app/Filament**: Contains Filament admin panel resources
- **app/Models**: Database models
- **database/migrations**: Database structure
- **database/seeders**: Sample data
- **resources/views**: Blade templates
- **resources/views/livewire**: Livewire component views
- **resources/css**: CSS and Tailwind configuration
- **public/storage**: Public storage for product images

## Customization

### Themes

The application uses Tailwind CSS for styling. You can customize the theme by editing the `tailwind.config.js` file.

### Localization

All text strings are stored in the `resources/lang` directory. To add a new language, create a new folder with the language code and translate the strings.

## Deployment

### Server Requirements

- PHP 8.1 or higher
- Composer
- MySQL 5.7 or higher
- Web server (Nginx or Apache)
- SSL certificate (recommended for production)

### Deployment Steps

1. Set up your production environment
2. Clone the repository
3. Install dependencies with `composer install --optimize-autoloader --no-dev`
4. Configure your `.env` file for production
5. Generate application key with `php artisan key:generate`
6. Run migrations with `php artisan migrate`
7. Build assets with `npm run build`
8. Configure your web server to point to the `public` directory
9. Set up proper permissions for storage and cache directories

## Contributing

1. Fork the repository
2. Create a feature branch: `git checkout -b feature-name`
3. Commit your changes: `git commit -m 'Add some feature'`
4. Push to the branch: `git push origin feature-name`
5. Submit a pull request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Acknowledgements

- [Laravel](https://laravel.com)
- [Livewire](https://laravel-livewire.com)
- [Tailwind CSS](https://tailwindcss.com)
- [Alpine.js](https://alpinejs.dev)
- [Filament](https://filamentphp.com)

## Contact

For any inquiries, please reach out to [your-email@example.com](mailto:your-email@example.com).