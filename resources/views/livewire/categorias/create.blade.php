<div>
    <form wire:submit="save">
        @include('livewire.inputs.text',[   
            'name' => 'nome', 
            'model' => 'form.nome',
            'label' => 'Nome',
        ])

        @include('livewire.inputs.radiobox',[   
            'name' => 'estado', 
            'model' => 'form.estado',
            'label' => 'Estado',
            'options' => [
                '0' => 'Desativado',
                '1' => 'Ativado',
            ]
        ])

                @include('livewire.inputs.selectbox',[   
            'name' => 'estado', 
            'model' => 'form.estado',
            'label' => 'Estado',
            'options' => [
                '0' => 'Desativado',
                '1' => 'Ativado',
            ]
        ])
        
 
 
    <button type="submit">Save</button>
</form>


 





    </div>
