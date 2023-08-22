export function getStatusName(status) {
    if(status == 1){
        return "Ativo";
    }else if(status == 2){
        return "Inativo";
    }else if(status == 3){
        return "Lixeira";
    }else{
        return "";
    }
}

export function getStatusColor(status){
    if(status == 1){
        return "positive";
    }else if(status == 2){
        return "warning";
    }else if(status == 3){
        return "negative";
    }else{
        return "";
    }
}
