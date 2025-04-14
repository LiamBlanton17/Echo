<?php

/**
 * TODO: Add Description
 */

// Traits
require(__DIR__.'/middleware/EchoUseMiddleware.php');
require(__DIR__.'/other/EchoErrors.php');
require(__DIR__.'/other/EchoEnv.php');
require(__DIR__.'/routing/EchoRouting.php');

// Core
require(__DIR__.'/other/EchoJSON.php');
require(__DIR__.'/main/EchoRequest.php');
require(__DIR__.'/main/EchoResponse.php');
require(__DIR__.'/other/EchoSession.php');
require(__DIR__.'/main/EchoApp.php');
require(__DIR__.'/routing/EchoRouter.php');
require(__DIR__.'/models/EchoModel.php');

// Middleware
require(__DIR__.'/middleware/EchoMiddleware.php');
require(__DIR__.'/middleware/EchoBaseMiddleware.php');
require(__DIR__.'/middleware/EchoJSONMiddleware.php');
require(__DIR__.'/middleware/EchoSessionMiddleware.php');
require(__DIR__.'/middleware/EchoXCSRFMiddleware.php');
require(__DIR__.'/middleware/EchoEnvMiddleware.php');
require(__DIR__.'/middleware/EchoResponseCacheMiddleware.php');
require(__DIR__.'/middleware/EchoDataCacheMiddleware.php');
require(__DIR__.'/middleware/EchoDatabaseMiddleware.php');

// Caching
require(__DIR__.'/cache/route-based/EchoCachingPolicyInterface.php');
require(__DIR__.'/cache/route-based/EchoResponseCache.php');
require(__DIR__.'/cache/route-based/EchoTTLPolicy.php');
require(__DIR__.'/cache/data-based/EchoDataCache.php');
require(__DIR__.'/cache/data-based/EchoDataCacheObject.php');
require(__DIR__.'/cache/data-based/EchoDataCachePolicyInterface.php');
require(__DIR__.'/cache/data-based/EchoDataCacheTTL.php');

// Database
require(__DIR__.'/database/EchoSQLMethods.php');
require(__DIR__.'/database/EchoDatabaseConnection.php');
require(__DIR__.'/database/EchoPDOConnection.php');
require(__DIR__.'/database/EchoSQLiteConnection.php');
require(__DIR__.'/database/EchoDatabaseFactory.php');