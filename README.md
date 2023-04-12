![banner](https://banners.beyondco.de/Codestyle.png?theme=dark&packageManager=composer+require&packageName=code050%2Fcodestyle&pattern=connections&style=style_1&description=The+official+Code050+codestyle+package&md=1&showWatermark=0&fontSize=100px&images=https%3A%2F%2Fwww.php.net%2Fimages%2Flogos%2Fnew-php-logo.svg)

# Code050 Codestyle

The official Code050 codestyle package.

## Guidelines

A description of the guidelines can be found in the [Code050 Codestyle Guidelines](guideline.md) document.

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
composer code050:codestyle:init
```

This will copy the stub configuration files to your project, but will not overwrite any existing files.
If you want to overwrite existing files, you can use the `-- --overwrite` flag. Note the double `--` before
the `--overwrite` flag.

When initializing the package in an existing project, chances are that you will get loads of errors from the
PHP_CodeSniffer
and PHPStan checks. This is because the stub configuration files are very strict and will enforce a lot of rules.
For PHPStan you can generate a baseline file to ignore all the errors.

But because PHP_CodeSniffer does not support a baseline file, you can use `--loose` flag to initialize the package with
a
looser configuration. This will report a lot of common errors as warnings instead of errors, so you can fix them at your
own pace. In the background the `--loose` flag will copy the `phpcs.loose.xml` file instead of the `phpcs.xml` file.
You can even extend this file with more custom rule mitigations, to get to the 0 error state.

### Running the checks

To ensure your code follows the Code050 codestyle, you need to run the PHP_CodeSniffer and PHPStan checks. You can run
the PHP_CodeSniffer checks by running the following command:

#### PHP_CodeSniffer

```bash
composer code050:codestyle:check
```

This command will check your code against the Code050 codestyle rules and provide feedback on any issues found.

To automatically fix any issues found by PHP_CodeSniffer, you can run the following command:

```bash
composer code050:codestyle:fix
```

#### PHPstan

You can run the PHPStan checks by running the following command:

```bash
composer code050:codestyle:stan
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

#### Example: configuring cognitive complexity
```xml
<rule ref="SlevomatCodingStandard.Complexity.Cognitive">
    <properties>
        <property name="warningThreshold" value="8"/>
        <property name="errorThreshold" value="8"/>
    </properties>
</rule>
```

### PHPStan

You can change the PHPStan configuration by editing the `phpstan.neon` file in the root of your project. You can find
more information about the rules that can be configured in
the [PHPStan documentation](https://phpstan.org/user-guide/getting-started).

#### Generating baseline

When you want to generate a baseline file, you can run the following command:

```bash
composer code050:codestyle:stan:baseline
```

This will generate a `phpstan-baseline.neon` file in the root of your project. It will also register this baseline in
your `phpstan.neon` file, so it will be used when running the PHPStan checks.

## General notes

If you encounter any issues with the package, please create an issue on
the [GitHub repository](https://github.com/code050/codestyle/issues).

## Workflow for legacy projects

Unfortunately, we can't just run the init and fixer commands on legacy projects.
This will probably break some things, but more often than not, after generation of a phpstan baseline, the project will
still have PHPStan errors.

These errors usually indicate serious problems in the code, that would probably throw exceptions when hit in production.
So, we need to fix these errors manually.

For PHP_CodeSniffer, we can use the `--loose` flag to generate a looser configuration. This will report a lot of common
errors as warnings instead of errors, so you can fix them at your own pace.
You can find a detailed explanation of the `--loose` flag in the [Initialization](#initializing-the-package) section.

So firstly we need to run the init command with the `--loose` flag:

```bash
composer code050:codestyle:init -- --loose
```

After this, we can run the PHP_CodeSniffer fixer command:

```bash
composer code050:codestyle:fix
```

Then we run PHPStan to generate a baseline file:

```bash
composer code050:codestyle:stan:baseline
```

The errors that remain after this, are the ones that need to be fixed manually.
For PHP_CodeSniffer, you can report these errors as warnings as described in
the [Initialization](#initializing-the-package) section.
For PHPStan, you should fix the error manually.
