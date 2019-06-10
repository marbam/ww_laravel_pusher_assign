<template>
    <div>
        <ul>
            <li v-for="player in players" v-text="player"></li>
        </ul>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                players: []
            }
        },
        created() {

           axios.get('/get_players/1', [])
                .then(res => {
                    this.players = res.data;  
                }).catch(err => {
                console.log(err)
            })

            window.Echo.channel('games').listen('PlayerCreated', e => {
                this.players.push(e.player.name);
            });
        }
    }
</script>
