import React, { useState } from "react";
import { useEffect } from "react";
import { useNavigate, useParams } from "react-router-dom";
import axiosClient from "../../axios-client";
import { useStateContext } from "../../contexts/ContextProvider";

const PlanForm = () => {
    const { id } = useParams();
    const navigate = useNavigate();
    const [loading, setLoading] = useState(false);
    const [errors, setErrors] = useState(null);
    const { setNotification } = useStateContext();
    const [clients, setClients] = useState([]);
    const [client, setClient] = useState([]);
    const [plan, setPlan] = useState({
        id: null,
        amount: null,
        battery_type: "",
        installments: null,
        paid_installments: null,
        deposit: null,
        balance: null,
        client_id: null,
    });

    const onSubmit = async (e) => {
        e.preventDefault();
        if (plan.id) {
            console.log(plan);
            await axiosClient
                .put(`/plans/${plan.id}`, plan)
                .then((response) => {
                    setNotification("Plan successfully updated");
                    navigate("/plans");
                })
                .catch((err) => {
                    const response = err.response;
                    if (response && response.status == 422) {
                        setErrors(response.data.errors);
                    }
                });
        } else {
            await axiosClient
                .post("/plans", plan)
                .then((response) => {
                    setNotification("Plan successfully created");
                    navigate("/plans");
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

    const getClient = async (clientId) => {
        await axiosClient.get(`/clients/${clientId}`).then(({ data }) => {
            setClient(data.data);
        });
    };

    const getPlan = async () => {
        setLoading(true);

        await axiosClient.get(`/plans/${id}`).then(({ data }) => {
            console.log(data);
            setLoading(false);
            setPlan(data);
        });
    };

    if (id) {
        useEffect(() => {
            getPlan();
        }, []);
    }

    useEffect(() => {
        getAllClients();
    }, []);

    return (
        <>
            <div className="bg-white p-5 shadow-md flex flex-col">
                {plan.id && (
                    <h2 className="text-xl font-lg text-center mb-4">
                        Update Plan
                    </h2>
                )}
                {!plan.id && (
                    <h2 className="text-xl font-lg text-center mb-4">
                        Create New Plan
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
                            <label htmlFor="">Amount</label>
                            <input
                                className="py-2 px-2 mb-3 border border-gray-200"
                                value={plan.amount}
                                onChange={(e) =>
                                    setPlan({ ...plan, amount: e.target.value })
                                }
                                placeholder="300"
                            />
                            <label htmlFor="">Battery Type</label>
                            <select
                                className="py-2 px-2 mb-3 border border-gray-200"
                                value={plan.battery_type}
                                onChange={(e) =>
                                    setPlan({
                                        ...plan,
                                        battery_type: e.target.value,
                                    })
                                }
                                name="battery_type"
                            >
                                <option value="">
                                    --- Select Battery Type ---
                                </option>
                                <option value="d_100_usd">D 100 USD</option>
                                <option value="d_100_usd">D 100 RTGS</option>
                            </select>
                            <label htmlFor="">Installments</label>
                            <input
                                className="py-2 px-2 mb-3 border border-gray-200"
                                type="text"
                                value={plan.installments}
                                onChange={(e) =>
                                    setPlan({
                                        ...plan,
                                        installments: e.target.value,
                                    })
                                }
                                placeholder="12"
                            />
                            <label htmlFor="">Deposit</label>
                            <input
                                className="py-2 px-2 mb-3 border border-gray-200"
                                value={plan.deposit}
                                onChange={(e) =>
                                    setPlan({
                                        ...plan,
                                        deposit: e.target.value,
                                    })
                                }
                                placeholder="10"
                            />
                            <label htmlFor="">Client</label>
                            <select
                                className="py-2 px-2 mb-3 border border-gray-200"
                                value={plan.client_id}
                                onChange={(e) =>
                                    setPlan({
                                        ...plan,
                                        client_id: e.target.value,
                                    })
                                }
                                name="role_id"
                            >
                                <option value="">--- Select Client ---</option>
                                {clients.map((client) => (
                                    <option key={client.id} value={client.id}>
                                        {client.name} - {client.id_number}
                                    </option>
                                ))}
                            </select>
                            <button className="py-3 bg-green-400 text-white">
                                {!plan.id && "CREATE"}
                                {plan.id && "UPDATE"}
                            </button>
                        </form>
                    )}
                </div>
            </div>
        </>
    );
};

export default PlanForm;
