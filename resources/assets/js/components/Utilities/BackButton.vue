<template lang="html">

    <div :style="`position: absolute; ${positionStyle || 'right: 0px; bottom: 60px'}`">
        <button @click="goBack" class="btn-back">
                {{text}}
        </button>
    </div>
</template>

<style>

        .btn-back {
            position: relative;
            border-radius: 4px;
            background-color: #0059b2;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 2px 2px 3px #999; 
            padding-left: 35px;
            font-weight: normal;
            padding-right: 15px;
            height: 36px;
            font-family: 'Open Sans';
            font-weight: bold;
            font-size: 14px;
            cursor: initial;
        }

        .btn-back::before {
            content: "\f0a8"; 
            font-family: FontAwesome;
            font-size: 15px;
            left: 13px;
            top: 1px;
            padding-top: 6px;
            position:absolute;
        }


</style>

<script>
export default {
    props: ['positionStyle', 'text', 'url'],
    methods:{
        goBack: function() {
            if (this.url) {
                window.location.href= this.url 
            } else {
                window.history.back();
            }
        }
    }
}
</script>


