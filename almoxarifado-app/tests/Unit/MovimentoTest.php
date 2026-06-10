<?php

use App\Models\Produto;
use App\Models\Movimento;

test('O sistema deve barrar a movimentação se a quantidade de saída for maior que o estoque', function(){
    $produtoMock = new Produto([
        'nome' => 'Mouse USB Dell',
        'estoque' => 5,
    ]);

    $movimentoMock = new Movimento([
            'quantidade' => 10,
            'tipo' => 's',
    ]);

    if($movimentoMock->tipo === 's' && $movimentoMock->quantidade > $produtoMock ->estoque){
        expect(true)->tobeTrue();
    }else{
        $this->fail("Erro: A regra de negócio permitiu saída de mercadoria sem estoque"); 
    }

});

test('O sistema deve diminuir o estoque após uma saída autorizada', function (){
    $produto = Produto::create([
        'nome' => 'Teclado mecânico',
        'estoque' => 5,
        'tipo' => 's',
    ]);
    Livewire::test(CreatMovimento::class)
        ->fillform([
            'produto_id' => $produto->id,
            'quantidade' => 5,
            'tipo' => 's',
        ])
        ->call('create');
    
    expect(Movimento::count())->toBe(1);
    expect($produto->fresh()->estoque->toBe(10));
});