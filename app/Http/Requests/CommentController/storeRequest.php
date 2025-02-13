<?php

namespace App\Http\Requests\CommentController;

use App\Models\Article;
use App\Models\Comment;
use App\Http\Requests\Request;
use Illuminate\Validation\Validator;

class storeRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'body' => 'required|string|max:1000|min:3',
            'commentable_id' => 'required|integer',
            'commentable_type' => 'required|string|in:article,comment',
        ];
    }

    /**
     * Modify the request data before validation.
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $type = $this->input('commentable_type');
            $id = $this->input('commentable_id');

            if ($type === 'comment') {
                $comment = Comment::find($id);

                if (!$comment) {
                    $validator->errors()->add('commentable_id', 'error');
                } elseif ($comment->isReply()) {
                    $validator->errors()->add('commentable_id', 'error');
                }
            } elseif ($type === 'article' && !Article::find($id)) {
                $validator->errors()->add('commentable_id', 'error');
            }
        });
    }
}
