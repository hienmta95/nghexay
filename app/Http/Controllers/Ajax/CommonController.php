<?php


namespace App\Http\Controllers\Ajax;

use App\Models\Post;
use App\Http\Controllers\FrontController;
use App\Models\SavedPost;
use App\Models\SavedSearch;
use App\Models\Scopes\VerifiedScope;
use App\Models\Scopes\ReviewedScope;
use App\Models\SkillType;
use Illuminate\Http\Request;
use Icetea\TextToImage\Facades\TextToImage;

class CommonController extends FrontController
{
    /**
     * PostController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSkillTypes(Request $request)
    {
        $keyword = $request->input('keyword', null);

        $query = SkillType::where('active', 1);
        if ($keyword) {
            $query->where('name', '%' . $keyword . '%');
        }
        $result = $query->get();

        if (empty($result)) {
            return response()->json(['error' => ['message' => t("Error. Post doesn't exist."),], 404]);
        }

        $items = $result->pluck('name', 'id');

        return response()->json($items, 200, [], JSON_UNESCAPED_UNICODE);
    }
}
