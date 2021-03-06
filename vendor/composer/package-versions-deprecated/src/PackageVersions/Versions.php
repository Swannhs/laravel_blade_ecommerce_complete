<?php

declare(strict_types=1);

namespace PackageVersions;

use Composer\InstalledVersions;
use OutOfBoundsException;

class_exists(InstalledVersions::class);

/**
 * This class is generated by composer/package-versions-deprecated, specifically by
 * @see \PackageVersions\Installer
 *
 * This file is overwritten at every run of `composer install` or `composer update`.
 *
 * @deprecated in favor of the Composer\InstalledVersions class provided by Composer 2. Require composer-runtime-api:^2 to ensure it is present.
 */
final class Versions
{
    /**
     * @deprecated please use {@see self::rootPackageName()} instead.
     *             This constant will be removed in version 2.0.0.
     */
    const ROOT_PACKAGE_NAME = 'laravel/laravel';

    /**
     * Array of all available composer packages.
     * Dont read this array from your calling code, but use the \PackageVersions\Versions::getVersion() method instead.
     *
     * @var array<string, string>
     * @internal
     */
    const VERSIONS          = array (
  'anandsiddharth/laravel-paytm-wallet' => 'v2.0.0@5342add0719e9c5ca94fdd13f766e6a810f2ef45',
  'asm89/stack-cors' => 'v2.0.3@9cb795bf30988e8c96dd3c40623c48a877bc6714',
  'brian2694/laravel-toastr' => '5.56@98137445f55d981f3587800349f1aa7b045d7974',
  'brick/math' => '0.9.3@ca57d18f028f84f777b2168cd1911b0dee2343ae',
  'clue/stream-filter' => 'v1.5.0@aeb7d8ea49c7963d3b581378955dbf5bc49aa320',
  'composer/ca-bundle' => '1.3.1@4c679186f2aca4ab6a0f1b0b9cf9252decb44d0b',
  'composer/package-versions-deprecated' => '1.11.99.4@b174585d1fe49ceed21928a945138948cb394600',
  'dflydev/dot-access-data' => 'v3.0.1@0992cc19268b259a39e86f296da5f0677841f42c',
  'doctrine/cache' => '2.1.1@331b4d5dbaeab3827976273e9356b3b453c300ce',
  'doctrine/dbal' => '3.1.3@96b0053775a544b4a6ab47654dac0621be8b4cf8',
  'doctrine/deprecations' => 'v0.5.3@9504165960a1f83cc1480e2be1dd0a0478561314',
  'doctrine/event-manager' => '1.1.1@41370af6a30faa9dc0368c4a6814d596e81aba7f',
  'doctrine/inflector' => '2.0.4@8b7ff3e4b7de6b2c84da85637b59fd2880ecaa89',
  'doctrine/lexer' => '1.2.1@e864bbf5904cb8f5bb334f99209b48018522f042',
  'dragonmantank/cron-expression' => 'v3.1.0@7a8c6e56ab3ffcc538d05e8155bb42269abf1a0c',
  'egulias/email-validator' => '2.1.25@0dbf5d78455d4d6a41d186da50adc1122ec066f4',
  'embed/embed' => '3.4.17@2c0e112f7332597ec6a55174f2353e04859ba356',
  'ezyang/htmlpurifier' => 'v4.13.0@08e27c97e4c6ed02f37c5b2b20488046c8d90d75',
  'fideloper/proxy' => '4.4.1@c073b2bd04d1c90e04dc1b787662b558dd65ade0',
  'firebase/php-jwt' => 'v5.5.1@83b609028194aa042ea33b5af2d41a7427de80e6',
  'fruitcake/laravel-cors' => 'v2.0.4@a8ccedc7ca95189ead0e407c43b530dc17791d6a',
  'geoip2/geoip2' => 'v2.11.0@d01be5894a5c1a3381c58c9b1795cd07f96c30f7',
  'google/apiclient' => 'v2.11.0@7db9eb40c8ba887e81c0fe84f2888a967396cdfb',
  'google/apiclient-services' => 'v0.222.0@5a3a9a48b71a009a9dd973b01ca0c4c3ea6b13fc',
  'google/auth' => 'v1.18.0@21dd478e77b0634ed9e3a68613f74ed250ca9347',
  'graham-campbell/result-type' => 'v1.0.3@296c015dc30ec4322168c5ad3ee5cc11dae827ac',
  'guzzlehttp/guzzle' => '7.4.0@868b3571a039f0ebc11ac8f344f4080babe2cb94',
  'guzzlehttp/promises' => '1.5.1@fe752aedc9fd8fcca3fe7ad05d419d32998a06da',
  'guzzlehttp/psr7' => '2.1.0@089edd38f5b8abba6cb01567c2a8aaa47cec4c72',
  'hisorange/browser-detect' => '4.4.1@c36da007d43f310e49506ac47b7fd1fd4cd77611',
  'intervention/image' => '2.7.0@9a8cc99d30415ec0b3f7649e1647d03a55698545',
  'jaybizzle/crawler-detect' => 'v1.2.108@69a38c09f99ee056e7cca9fe7c8b1952fd62b837',
  'jorenvanhocht/laravel-share' => '4.1.0@9ad09ee5f65a64cf993169636366d9fa0b6a993c',
  'kingflamez/laravelrave' => 'v4.2.0@02ccc18e5f03fb25a12f898ddd180d88d0ed13d9',
  'laravel/framework' => 'v8.70.2@dec9524cd0f9fa35a6eb8e25d0b40f8bbc8ec225',
  'laravel/sanctum' => 'v2.12.1@e610647b04583ace6b30c8eb74cee0a866040420',
  'laravel/serializable-closure' => 'v1.0.3@6cfc678735f22ccedad761b8cae2bab14c3d8e5b',
  'laravel/socialite' => 'v5.2.5@fd0f6a3dd963ca480b598649b54f92d81a43617f',
  'laravel/tinker' => 'v2.6.2@c808a7227f97ecfd9219fbf913bad842ea854ddc',
  'laravel/ui' => 'v3.3.2@28f3d190fe270b6dcd6fdab4a77a392e693ceca5',
  'laravelcollective/html' => 'v6.2.1@ae15b9c4bf918ec3a78f092b8555551dd693fde3',
  'league/commonmark' => '2.0.2@2df87709f44b0dd733df86aef0830dce9b1f0f13',
  'league/config' => 'v1.1.1@a9d39eeeb6cc49d10a6e6c36f22c4c1f4a767f3e',
  'league/flysystem' => '1.1.5@18634df356bfd4119fe3d6156bdb990c414c14ea',
  'league/fractal' => '0.19.2@06dc15f6ba38f2dde2f919d3095d13b571190a7c',
  'league/mime-type-detection' => '1.8.0@b38b25d7b372e9fddb00335400467b223349fd7e',
  'league/oauth1-client' => 'v1.10.0@88dd16b0cff68eb9167bfc849707d2c40ad91ddc',
  'league/omnipay' => 'v3.2.1@38f66a0cc043ed51d6edf7956d6439a2f263501f',
  'league/pipeline' => '1.0.0@aa14b0e3133121f8be39e9a3b6ddd011fc5bb9a8',
  'livewire/livewire' => 'v2.7.2@991e5bd8a48e450d23cd55336964f916e92a6464',
  'maatwebsite/excel' => '3.1.33@b2de5ba92c5c1ad9415f0eb7c72838fb3eaaa5b8',
  'maennchen/zipstream-php' => '2.1.0@c4c5803cc1f93df3d2448478ef79394a5981cc58',
  'markbaker/complex' => '3.0.1@ab8bc271e404909db09ff2d5ffa1e538085c0f22',
  'markbaker/matrix' => '3.0.0@c66aefcafb4f6c269510e9ac46b82619a904c576',
  'matomo/device-detector' => '4.3.1@88e5419ee1448ccb9537e287dd09836ff9d2de3b',
  'maxmind-db/reader' => 'v1.11.0@b1f3c0699525336d09cc5161a2861268d9f2ae5b',
  'maxmind/web-service-common' => 'v0.8.1@32f274051c543fc865e5a84d3a2c703913641ea8',
  'mews/purifier' => '3.3.6@1d033fc32b98036226002c38747d4a45424d5f28',
  'midtrans/midtrans-php' => '2.5.2@a1ad0c824449ca8c68c4cf11b3417ad518311d2b',
  'mobiledetect/mobiledetectlib' => '2.8.37@9841e3c46f5bd0739b53aed8ac677fa712943df7',
  'moneyphp/money' => 'v3.3.1@122664c2621a95180a13c1ac81fea1d2ef20781e',
  'monolog/monolog' => '2.3.5@fd4380d6fc37626e2f799f29d91195040137eba9',
  'mpdf/mpdf' => 'v8.0.15@d8a5294a6cc2e814c4157aecc8d7ac25014b18ed',
  'mustangostang/spyc' => '0.6.3@4627c838b16550b666d15aeae1e5289dd5b77da0',
  'myclabs/deep-copy' => '1.10.2@776f831124e9c62e1a2c601ecc52e776d8bb7220',
  'myclabs/php-enum' => '1.8.3@b942d263c641ddb5190929ff840c68f78713e937',
  'nesbot/carbon' => '2.54.0@eed83939f1aed3eee517d03a33f5ec587ac529b5',
  'nette/schema' => 'v1.2.2@9a39cef03a5b34c7de64f551538cbba05c2be5df',
  'nette/utils' => 'v3.2.5@9cd80396ca58d7969ab44fc7afcf03624dfa526e',
  'nikic/php-parser' => 'v4.13.1@63a79e8daa781cac14e5195e63ed8ae231dd10fd',
  'niklasravnsborg/laravel-pdf' => 'v4.1.0@a5f5c22dd5e10d8f536102cec01c21282e18ebae',
  'nwidart/laravel-modules' => '8.2.0@6ade5ec19e81a0e4807834886a2c47509d069cb7',
  'omnipay/common' => 'v3.1.2@5b16387ec5ab1b9ff86bdf0f20415088693b9948',
  'omnipay/paypal' => 'v3.0.2@519db61b32ff0c1e56cbec94762b970ee9674f65',
  'opis/closure' => '3.6.2@06e2ebd25f2869e54a306dda991f7db58066f7f6',
  'ourcodeworld/name-that-color' => 'dev-master@758b1f9b4b521da63f0ae4226e80cae620b0f648',
  'paragonie/constant_time_encoding' => 'v2.4.0@f34c2b11eb9d2c9318e13540a1dbc2a3afbd939c',
  'paragonie/random_compat' => 'v9.99.100@996434e5492cb4c3edcb9168db6fbb1359ef965a',
  'php-http/discovery' => '1.14.1@de90ab2b41d7d61609f504e031339776bc8c7223',
  'php-http/guzzle7-adapter' => '1.0.0@fb075a71dbfa4847cf0c2938c4e5a9c478ef8b01',
  'php-http/httplug' => '2.2.0@191a0a1b41ed026b717421931f8d3bd2514ffbf9',
  'php-http/message' => '1.12.0@39eb7548be982a81085fe5a6e2a44268cd586291',
  'php-http/message-factory' => 'v1.0.2@a478cb11f66a6ac48d8954216cfed9aa06a501a1',
  'php-http/promise' => '1.1.0@4c4c1f9b7289a2ec57cde7f1e9762a5789506f88',
  'phpoffice/phpspreadsheet' => '1.19.0@a9ab55bfae02eecffb3df669a2e19ba0e2f04bbf',
  'phpoption/phpoption' => '1.8.0@5455cb38aed4523f99977c4a12ef19da4bfe2a28',
  'phpseclib/phpseclib' => '3.0.11@6e794226a35159eb06f355efe59a0075a16551dd',
  'psr/cache' => '1.0.1@d11b50ad223250cf17b86e38383413f5a6764bf8',
  'psr/container' => '1.1.2@513e0666f7216c7459170d56df27dfcefe1689ea',
  'psr/event-dispatcher' => '1.0.0@dbefd12671e8a14ec7f180cab83036ed26714bb0',
  'psr/http-client' => '1.0.1@2dfb5f6c5eff0e91e20e913f8c5452ed95b86621',
  'psr/http-factory' => '1.0.1@12ac7fcd07e5b077433f5f2bee95b3a771bf61be',
  'psr/http-message' => '1.0.1@f6561bf28d520154e4b0ec72be95418abe6d9363',
  'psr/log' => '1.1.4@d49695b909c3b7628b6289db5479a1c204601f11',
  'psr/simple-cache' => '1.0.1@408d5eafb83c57f6365a3ca330ff23aa4a5fa39b',
  'psy/psysh' => 'v0.10.9@01281336c4ae557fe4a994544f30d3a1bc204375',
  'ralouphie/getallheaders' => '3.0.3@120b605dfeb996808c31b6477290a714d356e822',
  'ramsey/collection' => '1.2.2@cccc74ee5e328031b15640b51056ee8d3bb66c0a',
  'ramsey/uuid' => '4.2.3@fc9bb7fb5388691fd7373cd44dcb4d63bbcf24df',
  'razorpay/razorpay' => '2.8.1@4ad7b6a5bd9896305858ec0a861f66020e39f628',
  'rmccue/requests' => 'v1.8.0@afbe4790e4def03581c4a0963a1e8aa01f6030f1',
  'setasign/fpdi' => 'v2.3.6@6231e315f73e4f62d72b73f3d6d78ff0eed93c31',
  'silviolleite/laravelpwa' => '2.0.3@5f7135d2ee870af01793c9fdf6b1b932b546e20e',
  'softon/indipay' => 'v1.2.4@1ce64ec34212c8be0146a5e1b62e7b27409c45fd',
  'spatie/db-dumper' => '2.21.1@05e5955fb882008a8947c5a45146d86cfafa10d1',
  'spatie/laravel-analytics' => '3.11.0@6ce4610eea86e59446866504f71dcb17ddc8c496',
  'spondonit/amazcart-service' => 'v1.0.7@11273f8cc15bacfdb4ed90a9fe68612b39169856',
  'spondonit/service' => 'dev-master@f223b5e3946eab9c55970ce25a34d174693bd1d3',
  'stevebauman/location' => 'v6.2.0@cc2e63fc2b64f17d4404fe206612bc67dca16b10',
  'stripe/stripe-php' => 'v7.100.0@3dfc3dcd5d967a14d2852f34e544188af5f9b799',
  'swiftmailer/swiftmailer' => 'v6.3.0@8a5d5072dca8f48460fce2f4131fcc495eec654c',
  'symfony/cache' => 'v5.3.10@2056f2123f47c9f63102a8b92974c362f4fba568',
  'symfony/cache-contracts' => 'v2.4.0@c0446463729b89dd4fa62e9aeecc80287323615d',
  'symfony/console' => 'v5.3.10@d4e409d9fbcfbf71af0e5a940abb7b0b4bad0bd3',
  'symfony/css-selector' => 'v5.3.4@7fb120adc7f600a59027775b224c13a33530dd90',
  'symfony/deprecation-contracts' => 'v2.4.0@5f38c8804a9e97d23e0c8d63341088cd8a22d627',
  'symfony/error-handler' => 'v5.3.7@3bc60d0fba00ae8d1eaa9eb5ab11a2bbdd1fc321',
  'symfony/event-dispatcher' => 'v5.3.7@ce7b20d69c66a20939d8952b617506a44d102130',
  'symfony/event-dispatcher-contracts' => 'v2.4.0@69fee1ad2332a7cbab3aca13591953da9cdb7a11',
  'symfony/finder' => 'v5.3.7@a10000ada1e600d109a6c7632e9ac42e8bf2fb93',
  'symfony/http-client-contracts' => 'v2.4.0@7e82f6084d7cae521a75ef2cb5c9457bbda785f4',
  'symfony/http-foundation' => 'v5.3.10@9f34f02e8a5fdc7a56bafe011cea1ce97300e54c',
  'symfony/http-kernel' => 'v5.3.10@703e4079920468e9522b72cf47fd76ce8d795e86',
  'symfony/mime' => 'v5.3.8@a756033d0a7e53db389618653ae991eba5a19a11',
  'symfony/polyfill-ctype' => 'v1.23.0@46cd95797e9df938fdd2b03693b5fca5e64b01ce',
  'symfony/polyfill-iconv' => 'v1.23.0@63b5bb7db83e5673936d6e3b8b3e022ff6474933',
  'symfony/polyfill-intl-grapheme' => 'v1.23.1@16880ba9c5ebe3642d1995ab866db29270b36535',
  'symfony/polyfill-intl-idn' => 'v1.23.0@65bd267525e82759e7d8c4e8ceea44f398838e65',
  'symfony/polyfill-intl-normalizer' => 'v1.23.0@8590a5f561694770bdcd3f9b5c69dde6945028e8',
  'symfony/polyfill-mbstring' => 'v1.23.1@9174a3d80210dca8daa7f31fec659150bbeabfc6',
  'symfony/polyfill-php72' => 'v1.23.0@9a142215a36a3888e30d0a9eeea9766764e96976',
  'symfony/polyfill-php73' => 'v1.23.0@fba8933c384d6476ab14fb7b8526e5287ca7e010',
  'symfony/polyfill-php80' => 'v1.23.1@1100343ed1a92e3a38f9ae122fc0eb21602547be',
  'symfony/polyfill-php81' => 'v1.23.0@e66119f3de95efc359483f810c4c3e6436279436',
  'symfony/process' => 'v5.3.7@38f26c7d6ed535217ea393e05634cb0b244a1967',
  'symfony/routing' => 'v5.3.7@be865017746fe869007d94220ad3f5297951811b',
  'symfony/service-contracts' => 'v2.4.0@f040a30e04b57fbcc9c6cbcf4dbaa96bd318b9bb',
  'symfony/string' => 'v5.3.10@d70c35bb20bbca71fc4ab7921e3c6bda1a82a60c',
  'symfony/translation' => 'v5.3.10@6ef197aea2ac8b9cd63e0da7522b3771714035aa',
  'symfony/translation-contracts' => 'v2.4.0@95c812666f3e91db75385749fe219c5e494c7f95',
  'symfony/var-dumper' => 'v5.3.10@875432adb5f5570fff21036fd22aee244636b7d1',
  'symfony/var-exporter' => 'v5.3.8@a7604de14bcf472fe8e33f758e9e5b7bf07d3b91',
  'tijsverkoyen/css-to-inline-styles' => '2.2.3@b43b05cf43c1b6d849478965062b6ef73e223bb5',
  'twilio/sdk' => '6.31.0@9a866ad7e6b4681c7d9564ee7b9d97cb67deb6a0',
  'ua-parser/uap-php' => 'v3.9.14@b796c5ea5df588e65aeb4e2c6cce3811dec4fed6',
  'unicodeveloper/laravel-paystack' => '1.0.7@bfcb92255c29d92b0c4e80355a65de14e2e156f3',
  'van-ons/laraberg' => 'v1.1.1@35a6266c3877b3585942f990589de90489554e2b',
  'vlucas/phpdotenv' => 'v5.4.0@d4394d044ed69a8f244f3445bcedf8a0d7fe2403',
  'voku/portable-ascii' => '1.5.6@80953678b19901e5165c56752d087fc11526017c',
  'webmozart/assert' => '1.10.0@6964c76c7804814a842473e0c8fd15bab0f18e25',
  'yajra/laravel-datatables' => 'v1.5.0@50de5e20ef01da1a353e0a81c0ad5f9da6a985ec',
  'yajra/laravel-datatables-buttons' => 'v4.13.3@5c8fb97c26c14408c8933f68d86c6e4823d05740',
  'yajra/laravel-datatables-editor' => 'v1.25.0@096282402265a7a3aad06ce88df33d13968a3a5f',
  'yajra/laravel-datatables-fractal' => 'v1.6.0@0aa387a9b3738248fa61110f0378904ef42b4a73',
  'yajra/laravel-datatables-html' => 'v4.41.0@9e5d9edf397a7311751d09377a93b47aafe7e77b',
  'yajra/laravel-datatables-oracle' => 'v9.18.2@f4eebc1dc2b067058dfb91e7c067de862353c40f',
  'laravel/laravel' => '1.0.0+no-version-set@',
);

    private function __construct()
    {
    }

    /**
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall we know that {@see InstalledVersions} interaction does not
     *                                  cause any side effects here.
     */
    public static function rootPackageName() : string
    {
        if (!self::composer2ApiUsable()) {
            return self::ROOT_PACKAGE_NAME;
        }

        return InstalledVersions::getRootPackage()['name'];
    }

    /**
     * @throws OutOfBoundsException If a version cannot be located.
     *
     * @psalm-param key-of<self::VERSIONS> $packageName
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall we know that {@see InstalledVersions} interaction does not
     *                                  cause any side effects here.
     */
    public static function getVersion(string $packageName): string
    {
        if (self::composer2ApiUsable()) {
            return InstalledVersions::getPrettyVersion($packageName)
                . '@' . InstalledVersions::getReference($packageName);
        }

        if (isset(self::VERSIONS[$packageName])) {
            return self::VERSIONS[$packageName];
        }

        throw new OutOfBoundsException(
            'Required package "' . $packageName . '" is not installed: check your ./vendor/composer/installed.json and/or ./composer.lock files'
        );
    }

    private static function composer2ApiUsable(): bool
    {
        if (!class_exists(InstalledVersions::class, false)) {
            return false;
        }

        if (method_exists(InstalledVersions::class, 'getAllRawData')) {
            $rawData = InstalledVersions::getAllRawData();
            if (count($rawData) === 1 && count($rawData[0]) === 0) {
                return false;
            }
        } else {
            $rawData = InstalledVersions::getRawData();
            if ($rawData === null || $rawData === []) {
                return false;
            }
        }

        return true;
    }
}
