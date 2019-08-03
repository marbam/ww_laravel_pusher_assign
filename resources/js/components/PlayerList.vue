<template>
    <div class="players">
        <h1>Players in game({{players.length}})</h1>
        <div>
            <ul>
                <li v-if="!players.length" v-text="startLabel"></li>
                <li v-if="players.length" v-for="player in players" v-text="player"></li>
            </ul>
        </div>
    <button id="proceed_button" class="btn btn-success" :data-players='players.length' :data-roles='roleCount'>Proceed</button>
    <span style="font-style:italic">(You can only submit the game when players = number of roles in)</span>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                players: [],
                startLabel: 'None',
                roleCount: 0,
            }
        },
        created() {
           axios.get("/get_players/"+gameId, [])
                .then(res => {
                    if (res.data.players.length ) {
                        this.players = res.data.players;
                    }
                    this.roleCount = res.data.roles;
                }).catch(err => {
                console.log(err)
            })

            window.Echo.channel('games-'+gameId).listen('PlayerCreated', e => {
                this.players.push(e.player.name);
            });
        }
    }
</script>
