import React, { useEffect, useState } from "react";
import { useNavigate, useParams } from "react-router-dom";
import axiosClient from "../../axios-client";
import { useStateContext } from "../../contexts/ContextProvider";

const ClientForm = () => {
    const { id } = useParams();
    const navigate = useNavigate();
    const [loading, setLoading] = useState(false);
    const [errors, setErrors] = useState(null);
    const { setNotifiation } = useStateContext();
    const [client, setClient] = useState({
        id: null,
        id_number: "",
        dob: "",
        ec_number: "",
        type: "",
        battery_number: null,
        docs: "",
        created_by: "",
    });

    const getClient = () => {
        setLoading(true);

        axiosClient.get(`/clients/${id}`).then(({ data }) => {
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
            <div className="bg-white p-5 shadow-md flex flex-col">
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
                        <form className="flex flex-col">
                            <label htmlFor="">Full Name</label>
                            <input
                                className="py-2 px-2 mb-3 border border-gray-200"
                                value={client.name}
                                onChange={(e) =>
                                    setclient({
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
                                    setclient({
                                        ...client,
                                        id_number: e.target.value,
                                    })
                                }
                                placeholder="masyakudakwashe@gmail.com"
                            />
                            <label htmlFor="">EC Number</label>
                            <input
                                className="py-2 px-2 mb-3 border border-gray-200"
                                value={client.ec_number}
                                onChange={(e) =>
                                    setclient({
                                        ...client,
                                        ec_number: e.target.value,
                                    })
                                }
                                placeholder="KUD007"
                            />
                            <label htmlFor="">Type</label>
                            <input
                                className="py-2 px-2 mb-3 border border-gray-200"
                                value={client.type}
                                onChange={(e) =>
                                    setclient({
                                        ...client,
                                        type: e.target.value,
                                    })
                                }
                                placeholder="creator123"
                            />
                            <label htmlFor="">D.O.B</label>
                            <input
                                className="py-2 px-2 mb-3 border border-gray-200"
                                value={client.dob}
                                onChange={(e) =>
                                    setclient({
                                        ...client,
                                        dob: e.target.value,
                                    })
                                }
                                placeholder="creator123"
                            />
                            <label htmlFor="">Battery Number</label>
                            <input
                                className="py-2 px-2 mb-3 border border-gray-200"
                                value={client.battery_number}
                                onChange={(e) =>
                                    setclient({
                                        ...client,
                                        battery_number: e.target.value,
                                    })
                                }
                                placeholder="+263719123456"
                            />
                            {/* <label htmlFor="">Type</label>
                            <select className="py-2 px-2 mb-3 border border-gray-200">
                                <option value="" disabled>
                                    --- Select Type ---
                                </option>
                                <option value="2">Admin</option>
                                <option value="3">Administration</option>
                                <option value="4">SalesRep</option>
                            </select> */}

                            <div className="flex justify-between">
                                <button className="py-3 bg-green-400 text-white w-1/2">
                                    {!client.id && "CREATE"}
                                    {client.id && "UPDATE"}
                                </button>
                                <button className="py-3 bg-red-400 text-white w-1/2">
                                    CANCEL
                                </button>
                            </div>
                        </form>
                    )}
                </div>
            </div>
        </>
    );
};

export default ClientForm;
