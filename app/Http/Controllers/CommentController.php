<?php

namespace App\Http\Controllers;

use App\Commands\Services\Comment\PostCommentService;
use App\Http\Requests\PostCommentRequest;
use App\Queries\Services\CommentQueryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use RuntimeException;

final class CommentController extends Controller
{
    public function getComments(CommentQueryService $queryService, string $slug, Request $request): JsonResponse
    {
        $comments = $queryService->getCommentsOfArticle($slug, $request->user());
        return new JsonResponse([
            'comments' => $comments,
        ]);
    }

    public function postComment(
        PostCommentService $service,
        CommentQueryService $queryService,
        string $slug,
        PostCommentRequest $request
    ): JsonResponse {
        $input = $request->validated('comment');
        $currentUserId = $request->user();
        $writeModel = $service->handle($slug, $input['body'], $currentUserId);
        $readModel = $queryService->getSingleComment($writeModel->id, $currentUserId);

        if (is_null($readModel)) {
            throw new RuntimeException(sprintf('$readModel is unexpectedly set to null'));
        }

        return new JsonResponse([
            'comment' => $readModel,
        ]);
    }

    public function deleteComment(): JsonResponse
    {
        return new JsonResponse();
    }
}
