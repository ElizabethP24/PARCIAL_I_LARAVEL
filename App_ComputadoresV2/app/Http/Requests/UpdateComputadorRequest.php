<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateComputadorRequest extends FormRequest
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

        $computadorId = $this->route('id') ? $this->route('id') : null;

        return [
            'nombre' => 'required|string|max:255|unique:computadores,nombre,' . $computadorId,
            'marca' => 'nullable|string|max:100',
            'modelo' => 'nullable|string|max:100',
            'procesador' => 'nullable|string|max:100',
            'ram_gb' => 'required|integer|min:1',
            'almacenamiento_gb' => 'nullable|integer|min:1',
            'cantidad' => 'required|integer|min:0',
            'precio' => 'required|numeric|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'codigo_barras' => 'nullable|string|max:100|unique:computadores,codigo_barras,' . $computadorId,
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'portatil' => 'required|in:0,1',
        ];
    }
}
