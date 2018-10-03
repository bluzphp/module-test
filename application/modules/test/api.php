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
 *     path="/test/rest/",
 *     tags={"test"},
 *     method="GET",
 *     operationId="getTestCollection",
 *     summary="Collection of items",
 *     @OA\Parameter(ref="#/parameters/offset"),
 *     @OA\Parameter(ref="#/parameters/limit"),
 *     @OA\Response(response=200, description="Collection present"),
 *     @OA\Response(response=206, description="Collection present")
 * )
 *
 * @OA\Put(
 *     path="/test/rest/",
 *     tags={"test"},
 *     operationId="updateTestCollection",
 *     summary="Try to update Collection",
 *     @OA\Response(@OA\Schema(ref="#/definitions/error"), response=501, description="Not Implemented")
 * )
 *
 * @OA\Delete(
 *     path="/test/rest/",
 *     tags={"test"},
 *     operationId="deleteTestCollection",
 *     summary="Try to delete Collection",
 *     @OA\Response(@OA\Schema(ref="#/definitions/error"), response=400, description="Not Found")
 * )
 */

/**
 * @OA\Get(
 *     path="/test/rest/{itemId}",
 *     tags={"test"},
 *     operationId="getTestById",
 *     summary="Find item by ID",
 *     @OA\Parameter(
 *         name="itemId",
 *         in="path",
 *         description="ID of item that needs to be fetched",
 *         required=true,
 *         type="integer"
 *     ),
 *     @OA\Response(@OA\Schema(ref="#/definitions/test"), response=200, description="Given item found"),
 *     @OA\Response(@OA\Schema(ref="#/definitions/error"), response=404, description="Item not found")
 * )
 *
 * @OA\Post(
 *     path="/test/rest/",
 *     tags={"test"},
 *     operationId="createTest",
 *     summary="Create Item",
 *     @OA\Parameter(
 *         name="name",
 *         in="formData",
 *         description="Name",
 *         required=true,
 *         type="string",
 *     ),
 *     @OA\Parameter(
 *         name="email",
 *         in="formData",
 *         description="Email",
 *         required=true,
 *         type="string",
 *     ),
 *     @OA\Response(response=201, description="Item created, will return Location of created item"),
 *     @OA\Response(response=400, description="Validation errors")
 * )
 *
 * @OA\Post(
 *     path="/test/rest/{itemId}",
 *     tags={"test"},
 *     operationId="createTestWithId",
 *     summary="Try to create Item", *
 *     @OA\Parameter(
 *         name="itemId",
 *         in="path",
 *         description="ID of item that needs to be removed",
 *         required=true,
 *         type="integer"
 *     ),
 *     @OA\Response(@OA\Schema(ref="#/definitions/error"), response=501, description="Not Implemented")
 * )
 *
 * @OA\Put(
 *     path="/test/rest/{itemId}",
 *     tags={"test"},
 *     operationId="updateTest",
 *     summary="Update Item",
 *     @OA\Parameter(
 *         name="itemId",
 *         in="path",
 *         description="ID of item that needs to be updated",
 *         required=true,
 *         type="integer"
 *     ),
 *     @OA\Parameter(
 *         name="name",
 *         in="formData",
 *         description="Name",
 *         required=false,
 *         type="string",
 *     ),
 *     @OA\Parameter(
 *         name="email",
 *         in="formData",
 *         description="Email",
 *         required=false,
 *         type="string",
 *     ),
 *     @OA\Response(@OA\Schema(ref="#/definitions/error"), response=404, description="Item not found")
 * )
 *
 * @OA\Delete(
 *     path="/test/rest/{itemId}",
 *     tags={"test"},
 *     operationId="deleteTest",
 *     summary="Delete Item",
 *     @OA\Parameter(
 *         name="itemId",
 *         in="path",
 *         description="ID of item that needs to be removed",
 *         required=true,
 *         type="integer"
 *     ),
 *     @OA\Response(response=204, description="Item removed"),
 *     @OA\Response(response=404, description="Item not found")
 * )
 */
