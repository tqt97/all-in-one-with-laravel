<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use RectorLaravel\Rector\MethodCall\EloquentOrderByToLatestOrOldestRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/app',
        __DIR__.'/database',
        __DIR__.'/routes',
        __DIR__.'/tests',
    ])
    ->withRules([
        EloquentOrderByToLatestOrOldestRector::class,
        // EloquentMagicMethodToQueryBuilderRector::class,
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
