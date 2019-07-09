<template lang="html">
    <div>
        <h4 class="step-title" style="margin: 0px">Historial</h4>
         <table class="table" style="margin-top:10px;">

            <thead>
                <tr>
                    <th>Modificación</th>
                    <th>Fecha de modificación</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="itemHistory in this.historialData">
                    <td></td>
                    <td>{{itemHistory.created_at}}</td>
                </tr>
            </tbody>

        </table>

    </div>
</template>


<script>
export default {
    props: ['historial'],
    data() {
        return{
            historialData: ''
        }
    },

    computed: {
        historialData: _.sortBy(this.historial, (item) => item.created_at)
    }
}
</script>
