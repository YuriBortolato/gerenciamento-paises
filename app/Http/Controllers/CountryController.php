<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;

class CountryController extends Controller
{
    public function import()
    {
        $imported = $this->importCountries();

        return response()->json([
            'message' => 'Importação concluída',
            'total_processado' => $imported,
        ]);
    }

    public function importWeb()
    {
        $imported = $this->importCountries();

        return redirect()
            ->route('countries.index')
            ->with(
                'success',
                "{$imported} países foram processados sem duplicidades."
            );
    }

    private function importCountries(): int
    {
        $apiKey = env('REST_COUNTRIES_API_KEY');

        // ATENÇÃO: O token da API REST Countries deve ser configurado na variável REST_COUNTRIES_API_KEY do arquivo .env
        // Obtenha o seu token gratuito em: https://restcountries.com/
        if (empty($apiKey) || $apiKey === 'COLOQUE_SEU_TOKEN_AQUI') {
            abort(400, 'Chave de API da REST Countries não configurada no .env. Obtenha seu próprio token gratuito em https://restcountries.com/ e defina a variável REST_COUNTRIES_API_KEY.');
        }

        $response = Http::withToken($apiKey)
            ->timeout(30)
            ->get('https://api.restcountries.com/countries/v5');

        if ($response->failed()) {
            abort(502, 'Não foi possível consultar a REST Countries.');
        }

        $countries = $response->json('data.objects', []);
        $processed = 0;

        foreach ($countries as $country) {
            $isoCode = $country['codes']['alpha_2'] ?? null;

            if (!$isoCode) {
                continue;
            }

            Country::updateOrCreate(
                ['cca2' => strtoupper($isoCode)],
                [
                    'name' => $country['names']['common'] ?? '',
                    'capital' => $country['capitals'][0]['name'] ?? null,
                    'region' => $country['region'] ?? '',
                    'population' => $country['population'] ?? 0,
                    'flag_url' => $country['flag']['url_png'] ?? null,
                ]
            );

            $processed++;
        }

        return $processed;
    }

    public function index()
    {
        return Country::orderBy('name')->get();
    }

    public function page()
    {
        $countries = Country::orderBy('name')->get();

        return view('index', compact('countries'));
    }

    public function show($id)
    {
        return Country::findOrFail($id);
    }

    public function store(Request $request)
    {
        $country = Country::create(
            $this->validateCountry($request)
        );

        return response()->json($country, 201);
    }

    public function storeWeb(Request $request)
    {
        Country::create($this->validateCountry($request));

        return redirect()
            ->route('countries.index')
            ->with('success', 'País cadastrado com sucesso.');
    }

    public function editWeb($id)
    {
        $country = Country::findOrFail($id);

        return view('country-form', compact('country'));
    }

    public function showWeb($id)
    {
    $country = Country::findOrFail($id);

    return view('country-show', compact('country'));
    }

    public function update(Request $request, $id)
    {
        $country = Country::findOrFail($id);
        $country->update($this->validateCountry($request, $id));

        return response()->json($country);
    }

    public function updateWeb(Request $request, $id)
    {
        $country = Country::findOrFail($id);
        $country->update($this->validateCountry($request, $id));

        return redirect()
            ->route('countries.index')
            ->with('success', 'País atualizado com sucesso.');
    }

    public function destroy($id)
    {
        Country::findOrFail($id)->delete();

        return response()->json([
            'message' => 'País removido',
        ]);
    }

    public function destroyWeb($id)
    {
        Country::findOrFail($id)->delete();

        return redirect()
            ->route('countries.index')
            ->with('success', 'País removido com sucesso.');
    }

    private function validateCountry(
        Request $request,
        ?int $countryId = null
    ): array {
        $request->merge([
            'cca2' => strtoupper(
                trim((string) $request->input('cca2'))
            ),
        ]);

        return $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'cca2' => [
                    'required',
                    'string',
                    'size:2',
                    Rule::unique('countries', 'cca2')
                        ->ignore($countryId),
                ],
                'capital' => [
                    'nullable',
                    'string',
                    'max:255',
                ],
                'region' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'population' => [
                    'required',
                    'integer',
                    'min:0',
                ],
                'flag_url' => [
                    'nullable',
                    'url',
                    'max:500',
                ],
            ],
            [
                'name.required' => 'O nome do país é obrigatório.',
                'cca2.required' => 'O código ISO é obrigatório.',
                'cca2.size' => 'O código ISO deve possuir exatamente 2 letras.',
                'cca2.unique' => 'Já existe um país com esse código ISO.',
                'region.required' => 'A região é obrigatória.',
                'population.required' => 'A população é obrigatória.',
                'population.integer' => 'A população deve ser um número inteiro.',
                'population.min' => 'A população não pode ser negativa.',
                'flag_url.url' => 'A URL da bandeira deve ser válida.',
            ]
        );
    }
}