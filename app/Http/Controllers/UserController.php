<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Apenas admin pode gerenciar usuários
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->hasRole('admin')) {
                abort(403, 'Acesso negado. Você não tem permissão para gerenciar usuários.');
            }
            return $next($request);
        })->except(['show', 'edit', 'update']);
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Apenas admin pode listar usuários
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Acesso negado.');
        }
        
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|array',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        $user->assignRole($request->roles);

        return redirect()->route('users.index')
            ->with('success', 'Usuário criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // Usuários só podem ver seus próprios perfis, a menos que sejam admin
        if (Auth::id() !== $user->id && !Auth::user()->hasRole('admin')) {
            abort(403, 'Você não tem permissão para visualizar este perfil.');
        }
        
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Usuários só podem editar seus próprios perfis, a menos que sejam admin
        if (Auth::id() !== $user->id && !Auth::user()->hasRole('admin')) {
            abort(403, 'Você não tem permissão para editar este perfil.');
        }
        
        $roles = Role::all();
        $userRoles = $user->roles->pluck('id')->toArray();
        
        return view('users.edit', compact('user', 'roles', 'userRoles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Usuários só podem atualizar seus próprios perfis, a menos que sejam admin
        if (Auth::id() !== $user->id && !Auth::user()->hasRole('admin')) {
            abort(403, 'Você não tem permissão para atualizar este perfil.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);
        
        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];
        
        // Se uma nova senha for fornecida, atualize-a
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            
            $data['password'] = Hash::make($request->password);
        }
        
        $user->update($data);
        
        // Apenas admin pode atualizar funções
        if (Auth::user()->hasRole('admin') && $request->has('roles')) {
            $user->syncRoles($request->roles);
        }

        return redirect()->route(Auth::user()->hasRole('admin') ? 'users.index' : 'profile.show')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Não permitir que um admin exclua a si mesmo
        if (Auth::id() === $user->id) {
            return redirect()->route('users.index')
                ->with('error', 'Você não pode excluir seu próprio usuário.');
        }
        
        $user->delete();
        
        return redirect()->route('users.index')
            ->with('success', 'Usuário excluído com sucesso!');
    }
}
