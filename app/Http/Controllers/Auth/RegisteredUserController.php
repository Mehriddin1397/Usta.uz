<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Region;
use App\Models\Category;
use App\Models\Master;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $regions = Region::all();
        $categories = Category::all();

        return view('auth.register', compact('regions', 'categories'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'phone' => ['nullable', 'string', 'max:20'],
                'region_id' => ['required', 'exists:regions,id'],
                'user_type' => ['required', 'in:user,master'],
                'category_id' => ['required_if:user_type,master', 'exists:categories,id'],
                'description' => ['required_if:user_type,master', 'string', 'max:1000'],
                'experience_years' => ['required_if:user_type,master', 'integer', 'min:0', 'max:50'],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // If validation fails, redirect back with regions and categories
            $regions = Region::all();
            $categories = Category::all();
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with(compact('regions', 'categories'));
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'region_id' => $request->region_id,
            'role' => 'user', // Default role, admin will change to master if needed
        ]);

        // If user wants to be a master, create master profile
        if ($request->user_type === 'master') {
            Master::create([
                'user_id' => $user->id,
                'category_id' => $request->category_id,
                'description' => $request->description,
                'experience_years' => $request->experience_years,
                'is_approved' => false, // Needs admin approval
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        if ($request->user_type === 'master') {
            return redirect()->route('home')->with('success', 'Ro\'yxatdan o\'tdingiz! Usta sifatida faoliyat boshlash uchun admin tasdig\'ini kuting.');
        }

        return redirect()->route('home')->with('success', 'Ro\'yxatdan muvaffaqiyatli o\'tdingiz!');
    }


    public function edit(User $user)
    {
        return view('auth.update_user', [
            'user' => $user,
            'regions' => Region::all(),
            'categories' => Category::all(),
        ]);
    }


    public function update(Request $request, User $user)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => [
                    'required',
                    'string',
                    'lowercase',
                    'email',
                    'max:255',
                    Rule::unique(User::class)->ignore($user->id)
                ],
                'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
                'phone' => ['nullable', 'string', 'max:20'],
                'region_id' => ['required', 'exists:regions,id'],
                'user_type' => ['required', 'in:user,master'],
                'category_id' => ['required_if:user_type,master', 'exists:categories,id'],
                'description' => ['required_if:user_type,master', 'string', 'max:1000'],
                'experience_years' => ['required_if:user_type,master', 'integer', 'min:0', 'max:50'],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $regions = Region::all();
            $categories = Category::all();

            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with(compact('regions', 'categories'));
        }

        // ---- Userni yangilash ----
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'region_id' => $request->region_id,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        // ---- Master bo'lsa, profilni update qilish ----
        if ($request->user_type === 'master') {

            // Master profil bor yoki yo'qligini tekshiramiz
            $master = Master::where('user_id', $user->id)->first();

            if ($master) {
                // Agar bor bo'lsa — UPDATE
                $master->update([
                    'category_id' => $request->category_id,
                    'description' => $request->description,
                    'experience_years' => $request->experience_years,
                ]);
            } else {
                // Agar yo'q bo'lsa — CREATE
                Master::create([
                    'user_id' => $user->id,
                    'category_id' => $request->category_id,
                    'description' => $request->description,
                    'experience_years' => $request->experience_years,
                    'is_approved' => false,
                ]);
            }

        } else {
            // ---- Agar user master emas bo‘lsa → master profilini o‘chirish ----
            Master::where('user_id', $user->id)->delete();
            $user->update([
                'role' => 'user'
            ]);
        }

        return redirect()->route('home')
            ->with('success', "Ma'lumotlar muvaffaqiyatli yangilandi!");
    }

}
