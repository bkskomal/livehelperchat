import axios from "axios";

axios.defaults.headers.common['X-CSRFToken'] = confLH.csrf_token;

export function addPayload(payload) {
    return function(dispatch) {
        dispatch({type: "ADD_PAYLOAD_TRIGGERS"});

        axios.post(WWW_DIR_JAVASCRIPT + "genericbot/addpayload",payload)
        .then((response) => {
            dispatch({type: "ADD_PAYLOAD_TRIGGERS_FULFILLED", payload: response.data})
        })
        .catch((err) => {
            dispatch({type: "ADD_PAYLOAD_TRIGGERS_REJECTED", payload: err})
        })
    }
}