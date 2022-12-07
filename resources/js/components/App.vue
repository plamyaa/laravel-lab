<template>
    <div>
        <div v-show="(msg !== null)" class="alert alert-primary" role="alert">
            Добавлена новая статья: {{this.msg}}
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            msg: null,
        }
    },
    created() 
    {
        window.Echo.channel('Laravel-lab')
          .listen('NewArticleEvent', (name) => {
            console.log(name);
                this.msg = name.name;  
            });
        
    }
}
</script>

<style scoped>

</style>