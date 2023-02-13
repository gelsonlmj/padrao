<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Services\ClientService;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    /**
     * @var ClientService
     */
    var $clientService;

    public function __construct()
    {
        $this->clientService = new ClientService();
    }

    public function index()
    {
        $clients = $this->clientService->getLatest();
        return view('client.index', compact('clients'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('client.create');
    }

    public function store(Request $request)
    {
        $this->validator($request);
        $this->clientService->create($request->all());
        return redirect()->route('index')
                ->with('success','Cliente criado com sucesso.');
    }

    public function show(Client $client)
    {
        return view('client.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('client.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $this->validator($request);
        $client->update($request->all());

        return redirect()->route('client.index')
                ->with('success','Cliente atualizado com sucesso');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('index')
                ->with('success','Cliente removido com sucesso');
    }

    private function validator($parameters)
    {
        $parameters->validate([
            'name' => 'required',
            'fantasyName' => 'required',
            'documentNumber' => 'required',
            'active' => 'required'
        ]);
    }
}
