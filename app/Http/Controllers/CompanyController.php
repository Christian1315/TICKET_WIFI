<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Comment;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CompanyController extends Controller
{
    public function edit()
    {
        if (!auth()->user()->isAdmin()) {
            alert()->info("Accès réfusé!", "Vous n'êtes pas autorisé à accéder à ce panel!");
            return back();
        }

        $company = Company::firstOrNew();
        return view('company.edit', compact('company'));
    }

    public function update(CompanyRequest $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'name' => 'required|string|unique:companies',
                'address' => 'required',
                'email' => 'required|email|unique:companies',
                'phone' => ['required', Rule::unique("companies"), 'regex:/^\+?[0-9]{8,15}$/'],
            ], [
                'name.required' => 'Le nom est réquis!',
                'name.unique' => 'Ce nom existe déjà!',

                'address.required' => 'L\adresse est réquise!',

                'email.required' => 'Le mail est réquis!',
                'email.email' => 'Le mail n\'est pas valide',
                'email.unique' => 'Ce mail existe déjà!',

                'phone.required' => 'Le phone est réquis!',
                'phone.unique' => 'Ce phone existe déjà',
                'phone.regex' => 'Ce phone n\'est pas valide!',
            ]);

            /** */
            $company = Company::firstOrNew();
            $company->fill($request->validated());
            $company->save();

            DB::commit();
            alert()->success("Opération réussie!", "Modification éffectuée avec succès!");
            return back(); //->with('success', __('Update successful'));
        } catch (ValidationException $e) {
            DB::rollBack();
            alert()->error("Opération échouée!", "Erreure de validation des données!");
            Log::debug("Erreure de validation", ["data" => $e->errors()]);

            return back()->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            alert()->error("Opération échouée!", "Erreure lors de la modification du FAI");
            return back()->withInput();
        }
    }
}
