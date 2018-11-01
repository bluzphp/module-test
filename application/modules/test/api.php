<?php
/**
 * Annotations for swagger
 *
 * @category Example
 *
 * @author   Anton Shevchuk
 * @created  14.11.2014 18:02
 */

/**
 * @OA\Get(
 *   path="/test/rest/",
 *   tags={"test"},
 *   method="GET",
 *   operationId="getTestCollection",
 *   summary="Collection of items",
 *   @OA\Parameter(ref="#/components/parameters/offset_in_query"),
 *   @OA\Parameter(ref="#/components/parameters/limit_in_query"),
 *   @OA\Response(
 *     @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/test")),
 *     response=200,
 *     description="Collection"
 *   ),
 *   @OA\Response(
 *     @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/test")),
 *     response=206,
 *     description="Collection (partial)"
 *   )
 * )
 *
 * @OA\Put(
 *   path="/test/rest/",
 *   tags={"test"},
 *   operationId="updateTestCollection",
 *   summary="Try to update Collection",
 *   @OA\Response(@OA\JsonContent(ref="#/components/schemas/error"), response=501, description="Not Implemented")
 * )
 *
 * @OA\Delete(
 *   path="/test/rest/",
 *   tags={"test"},
 *   operationId="deleteTestCollection",
 *   summary="Try to delete Collection",
 *   @OA\Response(@OA\JsonContent(ref="#/components/schemas/error"), response=400, description="Not Found")
 * )
 */

/**
 * @OA\Get(
 *   path="/test/rest/{itemId}",
 *   tags={"test"},
 *   operationId="getTestById",
 *   summary="Find item by ID",
 *   @OA\Parameter(
 *     name="itemId",
 *     in="path",
 *     description="ID of item that needs to be fetched",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(@OA\JsonContent(ref="#/components/schemas/test"), response=200, description="Given item found"),
 *   @OA\Response(@OA\JsonContent(ref="#/components/schemas/error"), response=404, description="Item Not Found")
 * )
 *
 * @OA\Post(
 *   path="/test/rest/",
 *   tags={"test"},
 *   operationId="createTest",
 *   summary="Create Item",
 *   @OA\Parameter(
 *     name="name",
 *     in="query",
 *     description="Name",
 *     required=true,
 *     @OA\Schema(type="string")
 *   ),
 *   @OA\Parameter(
 *     name="email",
 *     in="query",
 *     description="Email",
 *     required=true,
 *     @OA\Schema(type="string")
 *   ),
 *   @OA\Response(response=201, description="Item created, will return Location of created item"),
 *   @OA\Response(@OA\JsonContent(ref="#/components/schemas/error"), response=400, description="Validation errors")
 * )
 *
 * @OA\Post(
 *   path="/test/rest/{itemId}",
 *   tags={"test"},
 *   operationId="createTestWithId",
 *   summary="Try to create Item", *
 *   @OA\Parameter(
 *     name="itemId",
 *     in="path",
 *     description="ID of item that needs to be removed",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(@OA\JsonContent(ref="#/components/schemas/error"), response=501, description="Not Implemented")
 * )
 *
 * @OA\Put(
 *   path="/test/rest/{itemId}",
 *   tags={"test"},
 *   operationId="updateTest",
 *   summary="Update Item",
 *   @OA\Parameter(
 *     name="itemId",
 *     in="path",
 *     description="ID of item that needs to be updated",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Parameter(
 *     name="name",
 *     in="query",
 *     description="Name",
 *     required=false,
 *     @OA\Schema(type="string")
 *   ),
 *   @OA\Parameter(
 *     name="email",
 *     in="query",
 *     description="Email",
 *     required=false,
 *     @OA\Schema(type="string")
 *   ),
 *   @OA\Response(@OA\JsonContent(ref="#/components/schemas/error"), response=404, description="Item Not Found")
 * )
 *
 * @OA\Delete(
 *   path="/test/rest/{itemId}",
 *   tags={"test"},
 *   operationId="deleteTest",
 *   summary="Delete Item",
 *   @OA\Parameter(
 *     name="itemId",
 *     in="path",
 *     description="ID of item that needs to be removed",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(@OA\JsonContent(ref="#/components/schemas/test"), response=204, description="Item removed"),
 *   @OA\Response(@OA\JsonContent(ref="#/components/schemas/error"), response=404, description="Item Not Found")
 * )
 */
