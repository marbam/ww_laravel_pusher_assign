<template>
    <div>
        <ul>
            <li v-for="faction in factions" v-text="faction.name"></li>
        </ul>



    </div>
</template>

<script>
    export default {
        data() {
            return {
                factions: [],
            }
        },
        created() {

           axios.get('/get_factions/1', [])
                .then(res => {
                    this.factions = res.data;
                    console.log(this.factions)
                }).catch(err => {
                console.log(err)
            })
        }
    }
</script>
