import React, { useEffect, useState } from "react";
import { useNavigate, useParams } from "react-router-dom";
import axiosClient from "../../axios-client";
import { useStateContext } from "../../contexts/ContextProvider";

const ClientForm = () => {
    const { id } = useParams();
    const navigate = useNavigate();
    const [loading, setLoading] = useState(false);
    const [errors, setErrors] = useState(null);
    const { setNotification } = useStateContext();
    const [client, setClient] = useState({
        id: null,
        name: "",
        id_number: "",
        ec_number: "",
        dob: null,
        type: "",
        battery_number: "",
        docs: "",
        created_by: "",
    });

    const onSubmit = async (e) => {
        e.preventDefault();
        if (client.id) {
            console.log(client);
            await axiosClient
                .put(`/clients/${client.id}`, client)
                .then((response) => {
                    setNotification("Client successfully updated");
                    navigate("/clients");
                })
                .catch((err) => {
                    const response = err.response;
                    if (response && response.status == 422) {
                        setErrors(response.data.errors);
                    }
                });
        } else {
            await axiosClient
                .post("/clients", client)
                .then((response) => {
                    console.log(client);
                    setNotification("Client successfully created");
                    navigate("/clients");
                })
                .catch((err) => {
                    const response = err.response;
                    if (response && response.status == 422) {
                        setErrors(response.data.errors);
                    }
                });
        }
    };

    const getClient = async () => {
        setLoading(true);

        await axiosClient.get(`/clients/${id}`).then(({ data }) => {
            console.log(data);
            setLoading(false);
            setClient(data);
        });
    };

    if (id) {
        useEffect(() => {
            getClient();
        }, []);
    }
    return (
        <>
            <div className="bg-white p-5 shadow-md flex flex-col border-2 border-orange-100">
                {client.id && (
                    <h2 className="text-xl font-lg text-center mb-4">
                        Update Client: {client.name}
                    </h2>
                )}
                {!client.id && (
                    <h2 className="text-xl font-lg text-center mb-4">
                        Create New Client
                    </h2>
                )}

                <div>
                    {loading && <div className="text-center">Loading...</div>}
                    {errors && (
                        <div className="alert">
                            {Object.keys(errors).map((key) => (
                                <p key={key}>{errors[key][0]}</p>
                            ))}
                        </div>
                    )}
                    {!loading && (
                        <form onSubmit={onSubmit} className="flex flex-col">
                            <label htmlFor="">Full Name</label>
                            <input
                                className="py-2 px-2 mb-3 border border-gray-200"
                                value={client.name}
                                onChange={(e) =>
                                    setClient({
                                        ...client,
                                        name: e.target.value,
                                    })
                                }
                                placeholder="Kudakwashe Masaya"
                            />
                            <label htmlFor="">ID Number</label>
                            <input
                                className="py-2 px-2 mb-3 border border-gray-200"
                                value={client.id_number}
                                onChange={(e) =>
                                    setClient({
                                        ...client,
                                        id_number: e.target.value,
                                    })
                                }
                                placeholder="59-123123N89"
                            />
                            <label htmlFor="">EC Number</label>
                            <input
                                className="py-2 px-2 mb-3 border border-gray-200"
                                value={client.ec_number}
                                onChange={(e) =>
                                    setClient({
                                        ...client,
                                        ec_number: e.target.value,
                                    })
                                }
                                placeholder="KUD007"
                            />
                            <label htmlFor="">D.O.B</label>
                            <input
                                className="py-2 px-2 mb-3 border border-gray-200"
                                value={client.dob}
                                onChange={(e) =>
                                    setClient({
                                        ...client,
                                        dob: e.target.value,
                                    })
                                }
                                type="date"
                                placeholder="10/12/1996"
                            />
                            <label htmlFor="">Type</label>
                            <select
                                className="py-2 px-2 mb-3 border border-gray-200"
                                value={client.type}
                                onChange={(e) =>
                                    setClient({
                                        ...client,
                                        type: e.target.value,
                                    })
                                }
                                name="role_id"
                            >
                                <option value="">--- Select Type ---</option>
                                <option value="vmum_usd">V-MUM - USD</option>
                                <option value="vmum_rtgs">V-MUM - RTGS</option>
                                <option value="ssb_usd">SSB - USD</option>
                                <option value="ssb_rtgs">SSB - RTGS</option>
                            </select>
                            <label htmlFor="">Battery Number</label>
                            <input
                                className="py-2 px-2 mb-3 border border-gray-200"
                                value={client.battery_number}
                                onChange={(e) =>
                                    setClient({
                                        ...client,
                                        battery_number: e.target.value,
                                    })
                                }
                                placeholder="123456BN"
                            />
                            <label htmlFor="">Documents</label>
                            <input
                                className="py-2 px-2 mb-3 border border-gray-200"
                                onChange={(e) =>
                                    setClient({
                                        ...client,
                                        docs: e.target.value,
                                    })
                                }
                                type="file"
                                multiple
                            />

                            <button className="py-3 bg-green-400 text-white">
                                {!client.id && "CREATE"}
                                {client.id && "UPDATE"}
                            </button>
                        </form>
                    )}
                </div>
            </div>
        </>
    );
};

export default ClientForm;
