![banner](https://banners.beyondco.de/Codestyle.png?theme=dark&packageManager=composer+require&packageName=code050%2Fcodestyle&pattern=connections&style=style_1&description=The+official+Code050+codestyle+package&md=1&showWatermark=0&fontSize=100px&images=https%3A%2F%2Fwww.php.net%2Fimages%2Flogos%2Fnew-php-logo.svg)

# Code050 Codestyle

The official Code050 codestyle package.

## Installation

You can install the package via composer:

```bash
composer require code050/codestyle
```

## Usage

The primary usage of the package is to provide a consistent code style for all Code050 projects.
We achieve this by using a combination of various tools. Currently, these tools include:

- PHPStan
- PHP_CodeSniffer

The package contains stub configurations for these tools which can be used in your project.

### Initializing the package

To initialize the package, you can run the following command:

```bash
php artisan code050:codestyle:init
```

This will copy the stub configuration files to your project, but will not overwrite any existing files.
If you want to overwrite existing files, you can use the `-- --overwrite` flag. Note the double `--` before
the `--overwrite` flag.

### Running the checks

To ensure your code follows the Code050 codestyle, you need to run the PHP_CodeSniffer and PHPStan checks. You can run
the PHP_CodeSniffer checks by running the following command:

#### PHP_CodeSniffer

```bash
php artisan code050:codestyle:check
```

This command will check your code against the Code050 codestyle rules and provide feedback on any issues found.

To automatically fix any issues found by PHP_CodeSniffer, you can run the following command:

```bash
php artisan code050:codestyle:fix
```

#### PHPstan

You can run the PHPStan checks by running the following command:

```bash
php artisan code050:codestyle:stan
```

This command will check your code against the Code050 PHPStan rules and provide feedback on any issues found.

## Configuration

### PHP_CodeSniffer

After initializing the package, you can configure the PHP_CodeSniffer rules by editing the `phpcs.xml` file in the root
of your project. You can find more information about the rules that can be configured in
the [PHP_CodeSniffer documentation](https://github.com/squizlabs/PHP_CodeSniffer/wiki).

Basically, when you want to ignore certain rules, you can add the following to the `phpcs.xml` file:

```xml

<rule ref="Code050">
    <exclude name="Generic.Files.LineLength"/>
</rule> 
```

### PHPStan

You can change the PHPStan configuration by editing the `phpstan.neon` file in the root of your project. You can find
more information about the rules that can be configured in
the [PHPStan documentation](https://phpstan.org/user-guide/getting-started).




