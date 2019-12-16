/**
 * AJAX call to API. Stores the auth key.
 * Either passes received data to be saved and rendered or load existing local data on fail.
 * Return Promise result
 */

function getDelegatesAJAX() {
    return new Promise(function (resolve) {

            var api_key;
            if (localStorage.getItem("api_key")) {
                api_key = localStorage.getItem("api_key")
            } else {
                api_key = "";
            }

            $.post(
                base_url + "/api/delegate/get",
                {
                    api_key: localStorage.getItem("api_key")
                },
                "json"
            ).done(function (data, status) {

                    if (JSON.parse(data)) {
                        json = JSON.parse(data);
                        if (json.new_key && json.data) {
                            // save key
                            localStorage.setItem("api_key", json.new_key);

                            // save in local db
                            saveCurrentDelegates(json.data);

                            // return json
                            resolve(json.data);
                        }

                    } else {
                        // get from local db, set global
                        results = getCurrentDelegates();

                    }

                    // back online
                    is_online();
                }
            ).error(function () {
                // note we are offline
                is_offline();

                getCurrentDelegates();
            })

        }
    );
}


/**
 * Saves API data the the local db
 */
function saveCurrentDelegates(delegates) {
    // prepare db
    var objStore = db.transaction(["checkinDB"], "readwrite")
        .objectStore("checkinDB");

    // loop through and update/insert by primary key, 'id'
    delegates.forEach(function (delegate) {
        var request = objStore.put({
            id: delegate['id'],
            checked_in: delegate["checked_in"],
            first_name: delegate["first_name"],
            last_name: delegate["last_name"],
            job_title: delegate["job_title"],
            company: delegate["company"],
            table_no: delegate["table_no"],
            arrived: 0
        });
    });

    // return all on success
    objStore.getAll().onsuccess = function (event) {
        return event.target.result;
    }

    // get all failure
    objStore.getAll().onerror = function (event) {
        return false;
    }

}
