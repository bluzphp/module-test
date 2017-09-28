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
 * @SWG\Get(
 *     path="/test/rest/",
 *     tags={"test"},
 *     method="GET",
 *     operationId="getTestCollection",
 *     summary="Collection of items",
 *     @SWG\Parameter(ref="#/parameters/offset"),
 *     @SWG\Parameter(ref="#/parameters/limit"),
 *     @SWG\Response(response=200, description="Collection present"),
 *     @SWG\Response(response=206, description="Collection present")
 * )
 *
 * @SWG\Put(
 *     path="/test/rest/",
 *     tags={"test"},
 *     operationId="updateTestCollection",
 *     summary="Try to update Collection",
 *     @SWG\Response(@SWG\Schema(ref="#/definitions/error"), response=501, description="Not Implemented")
 * )
 *
 * @SWG\Delete(
 *     path="/test/rest/",
 *     tags={"test"},
 *     operationId="deleteTestCollection",
 *     summary="Try to delete Collection",
 *     @SWG\Response(@SWG\Schema(ref="#/definitions/error"), response=400, description="Not Found")
 * )
 */

/**
 * @SWG\Get(
 *     path="/test/rest/{itemId}",
 *     tags={"test"},
 *     operationId="getTestById",
 *     summary="Find item by ID",
 *     @SWG\Parameter(
 *         name="itemId",
 *         in="path",
 *         description="ID of item that needs to be fetched",
 *         required=true,
 *         type="integer"
 *     ),
 *     @SWG\Response(@SWG\Schema(ref="#/definitions/test"), response=200, description="Given item found"),
 *     @SWG\Response(@SWG\Schema(ref="#/definitions/error"), response=404, description="Item not found")
 * )
 *
 * @SWG\Post(
 *     path="/test/rest/",
 *     tags={"test"},
 *     operationId="createTest",
 *     summary="Create Item",
 *     @SWG\Parameter(
 *         name="name",
 *         in="formData",
 *         description="Name",
 *         required=true,
 *         type="string",
 *     ),
 *     @SWG\Parameter(
 *         name="email",
 *         in="formData",
 *         description="Email",
 *         required=true,
 *         type="string",
 *     ),
 *     @SWG\Response(response=201, description="Item created, will return Location of created item"),
 *     @SWG\Response(response=400, description="Validation errors")
 * )
 *
 * @SWG\Post(
 *     path="/test/rest/{itemId}",
 *     tags={"test"},
 *     operationId="createTestWithId",
 *     summary="Try to create Item", *
 *     @SWG\Parameter(
 *         name="itemId",
 *         in="path",
 *         description="ID of item that needs to be removed",
 *         required=true,
 *         type="integer"
 *     ),
 *     @SWG\Response(@SWG\Schema(ref="#/definitions/error"), response=501, description="Not Implemented")
 * )
 *
 * @SWG\Put(
 *     path="/test/rest/{itemId}",
 *     tags={"test"},
 *     operationId="updateTest",
 *     summary="Update Item",
 *     @SWG\Parameter(
 *         name="itemId",
 *         in="path",
 *         description="ID of item that needs to be updated",
 *         required=true,
 *         type="integer"
 *     ),
 *     @SWG\Parameter(
 *         name="name",
 *         in="formData",
 *         description="Name",
 *         required=false,
 *         type="string",
 *     ),
 *     @SWG\Parameter(
 *         name="email",
 *         in="formData",
 *         description="Email",
 *         required=false,
 *         type="string",
 *     ),
 *     @SWG\Response(@SWG\Schema(ref="#/definitions/error"), response=404, description="Item not found")
 * )
 *
 * @SWG\Delete(
 *     path="/test/rest/{itemId}",
 *     tags={"test"},
 *     operationId="deleteTest",
 *     summary="Delete Item",
 *     @SWG\Parameter(
 *         name="itemId",
 *         in="path",
 *         description="ID of item that needs to be removed",
 *         required=true,
 *         type="integer"
 *     ),
 *     @SWG\Response(response=204, description="Item removed"),
 *     @SWG\Response(response=404, description="Item not found")
 * )
 */
