import React, { useEffect, useState } from "react";
import { useNavigate, useParams } from "react-router-dom";
import axiosClient from "../../axios-client";
import { useStateContext } from "../../contexts/ContextProvider";

const TokenForm = () => {
    const { id } = useParams();
    const navigate = useNavigate();
    const [loading, setLoading] = useState(false);
    const [errors, setErrors] = useState(null);
    const { setNotification } = useStateContext();
    const [clients, setClients] = useState([]);
    const [token, setToken] = useState({
        id: null,
        number: "",
        client_id: null,
    });

    const onSubmit = async (e) => {
        e.preventDefault();
        if (token.id) {
            console.log(token);
            await axiosClient
                .put(`/tokens/${token.id}`, token)
                .then((response) => {
                    setNotification("Token successfully updated");
                    navigate("/tokens");
                })
                .catch((err) => {
                    const response = err.response;
                    if (response && response.status == 422) {
                        setErrors(response.data.errors);
                    }
                });
        } else {
            await axiosClient
                .post("/tokens", token)
                .then((response) => {
                    setNotification("Token successfully created");
                    navigate("/tokens");
                })
                .catch((err) => {
                    const response = err.response;
                    if (response && response.status == 422) {
                        setErrors(response.data.errors);
                    }
                });
        }
    };

    const getAllClients = async () => {
        await axiosClient.get("/clients").then(({ data }) => {
            // setLoading(false);
            console.log(data.data);
            setClients(data.data);
        });
    };

    const getToken = async () => {
        setLoading(true);

        await axiosClient.get(`/tokens/${id}`).then(({ data }) => {
            console.log(data);
            setLoading(false);
            setToken(data);
        });
    };

    if (id) {
        useEffect(() => {
            getToken();
        }, []);
    }
    useEffect(() => {
        getAllClients();
    }, []);

    return (
        <>
            <div className="bg-white p-5 shadow-md flex flex-col">
                {token.id && (
                    <h2 className="text-xl font-lg text-center mb-4">
                        Update token
                    </h2>
                )}
                {!token.id && (
                    <h2 className="text-xl font-lg text-center mb-4">
                        Create New token
                    </h2>
                )}

                <div>
                    {loading && <div className="text-center">Loading...</div>}
                    {errors && (
                        <div className="bg-red-500 text-white p-2">
                            {Object.keys(errors).map((key) => (
                                <p key={key}>{errors[key][0]}</p>
                            ))}
                        </div>
                    )}
                    {!loading && (
                        <form onSubmit={onSubmit} className="flex flex-col">
                            <label htmlFor="">Number</label>
                            <input
                                className="py-2 px-2 mb-3 border border-gray-200"
                                value={token.number}
                                onChange={(e) =>
                                    setToken({
                                        ...token,
                                        number: e.target.value,
                                    })
                                }
                                placeholder="300"
                            />
                            <label htmlFor="">Client</label>
                            <select
                                className="py-2 px-2 mb-3 border border-gray-200"
                                value={token.client_id}
                                onChange={(e) =>
                                    setToken({
                                        ...token,
                                        client_id: e.target.value,
                                    })
                                }
                            >
                                <option value="">--- Select Client ---</option>
                                {clients.map((client) => (
                                    <option key={client.id} value={client.id}>
                                        {client.name} - {client.id_number}
                                    </option>
                                ))}
                            </select>
                            <button className="py-3 bg-green-400 text-white">
                                {!token.id && "CREATE"}
                                {token.id && "UPDATE"}
                            </button>
                        </form>
                    )}
                </div>
            </div>
        </>
    );
};

export default TokenForm;
