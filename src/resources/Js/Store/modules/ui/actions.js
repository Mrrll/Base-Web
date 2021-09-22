export function UI ( {commit} ){
    axios.get('/userUI').then((res)=> {
        commit('setUI',res.data)
    });
}
export function NavLists ( { commit }, navList){
    commit('setNavList', navList)
}