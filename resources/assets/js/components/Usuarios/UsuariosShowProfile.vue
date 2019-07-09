<template lang="html">

    <div>
            <div class="header-index">
                <span class="header-table">Perfil</span>
            </div>

            <div class="card-create-container" style="max-width: 1000px; float: left; width: 100%; margin-top: 0px ">    
                <span class="header-table" style="font-weight: bold; font-size: 20px; font-family: 'Open Sans';">Nombre: </span>
                <span class="header-table" style="font-size: 20px; font-family: 'Open Sans';">{{user.name}}</span>
                <br>    
                <span class="header-table" style="font-weight: bold; font-size: 20px; font-family: 'Open Sans';">Correo electrónico: </span>
                <span class="header-table" style="font-size: 20px; font-family: 'Open Sans';">{{user.email}}</span>
                <br>    
                <span class="header-table" style="font-weight: bold; font-size: 20px; font-family: 'Open Sans';">Rol: </span>
                <span class="header-table" style="font-size: 20px; font-family: 'Open Sans';">{{user.roles[0].name}}</span>
                <br>    
                <span class="header-table" style="font-weight: bold; font-size: 20px; font-family: 'Open Sans';">Cargo: </span>
                <span class="header-table" style="font-size: 20px; font-family: 'Open Sans';">{{user.cargo}}</span>

                <div style="float: right; margin-top:30px">
                    <button type="button" style="margin-right: 15px;" @click="onCancel" class="btn btn-cancelar">Cancelar</button>
                    <button @click="onEdit(user.id)" class="btn btn-edit">Editar</button>
                </div>

            </div>

            
    </div>

</template>

<script>
export default {
    props: ['user'],

    methods: {

        onCancel: () => window.history.back(),
        onEdit: (id) => window.location.href = `/user/perfil/${id}`
    }

}
</script>

