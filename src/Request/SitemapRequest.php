<?php

namespace Artjoker\Sitemap\Request;

use Illuminate\Foundation\Http\FormRequest;

class SitemapRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'alias' => 'required|unique:sitemap,alias,'.$this->route('sitemap'),
            'priority' => 'numeric',
            'is_loaded' => 'integer',
            'order' => 'integer',
            'active' => 'integer',
            'lastmod' => 'date',
        ];
    }

}
