<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;
use RectorLaravel\Rector\MethodCall\EloquentOrderByToLatestOrOldestRector;
use RectorLaravel\Rector\StaticCall\EloquentMagicMethodToQueryBuilderRector;
use RectorLaravel\Set\LaravelLevelSetList;
use RectorLaravel\Set\LaravelSetList;
use RectorLaravel\Set\LaravelSetProvider;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/app',
        __DIR__.'/database',
        __DIR__.'/routes',
        __DIR__.'/tests',
    ])
    // ->withSetProviders(LaravelSetProvider::class)
    // ->withComposerBased(laravel: true, )
    ->withSets([
        // SetList::CODE_QUALITY,
        // SetList::CODING_STYLE,
        // SetList::DEAD_CODE,

        // LaravelSetList::LARAVEL_CODE_QUALITY,
        // LaravelSetList::LARAVEL_COLLECTION,
        // LaravelSetList::LARAVEL_CONTAINER_STRING_TO_FULLY_QUALIFIED_NAME,
        // LaravelSetList::LARAVEL_TYPE_DECLARATIONS,

        // LaravelLevelSetList::UP_TO_LARAVEL_120,
        // LaravelSetList::LARAVEL_ELOQUENT_MAGIC_METHOD_TO_QUERY_BUILDER,
    ])
    // ->withPhpVersion(phpVersion: 84)
    ->withPreparedSets(
        // deadCode: true,
        // codeQuality: true,
        // codingStyle: true,
        // typeDeclarations: true,
        // privatization: true,
        // earlyReturn: true,
        // strictBooleans: true
    )
    ->withRules([
        EloquentOrderByToLatestOrOldestRector::class,
        EloquentMagicMethodToQueryBuilderRector::class,
        RectorLaravel\Rector\If_\AbortIfRector::class,
        RectorLaravel\Rector\Expr\AppEnvironmentComparisonToParameterRector::class,
        RectorLaravel\Rector\Coalesce\ApplyDefaultInsteadOfNullCoalesceRector::class,
        // RectorLaravel\Rector\ArrayDimFetch\ArrayToArrGetRector::class,
        RectorLaravel\Rector\MethodCall\ChangeQueryWhereDateValueWithCarbonRector::class,
        RectorLaravel\Rector\Empty_\EmptyToBlankAndFilledFuncRector::class,
        RectorLaravel\Rector\ArrayDimFetch\EnvVariableToEnvHelperRector::class,
        RectorLaravel\Rector\ClassMethod\MakeModelAttributesAndScopesProtectedRector::class,
        RectorLaravel\Rector\StaticCall\MinutesToSecondsInCacheRector::class,
        RectorLaravel\Rector\Class_\ModelCastsPropertyToCastsMethodRector::class,
        RectorLaravel\Rector\FuncCall\NowFuncWithStartOfDayMethodCallToTodayFuncRector::class,
        RectorLaravel\Rector\PropertyFetch\OptionalToNullsafeOperatorRector::class,
        RectorLaravel\Rector\StaticCall\Redirect301ToPermanentRedirectRector::class,
        RectorLaravel\Rector\MethodCall\RedirectBackToBackHelperRector::class,
        RectorLaravel\Rector\MethodCall\RedirectRouteToToRouteHelperRector::class,
        RectorLaravel\Rector\FuncCall\RemoveDumpDataDeadCodeRector::class,
        RectorLaravel\Rector\PropertyFetch\ReplaceFakerInstanceWithHelperRector::class,
        RectorLaravel\Rector\PropertyFetch\ReplaceFakerPropertyFetchWithMethodCallRector::class,
        RectorLaravel\Rector\StaticCall\RouteActionCallableRector::class,
        RectorLaravel\Rector\ClassMethod\ScopeNamedClassMethodToScopeAttributedClassMethodRector::class,
        // RectorLaravel\Rector\If_\ThrowIfRector::class,
        RectorLaravel\Rector\Class_\UnifyModelDatesWithCastsRector::class,
        RectorLaravel\Rector\MethodCall\ValidationRuleArrayStringValueToArrayRector::class,
        RectorLaravel\Rector\MethodCall\WhereToWhereLikeRector::class,
    ]);
