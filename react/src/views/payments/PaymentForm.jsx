import React, { useEffect, useState } from "react";
import { useNavigate, useParams } from "react-router-dom";
import axiosClient from "../../axios-client";
import { useStateContext } from "../../contexts/ContextProvider";

const PaymentForm = () => {
    const { id } = useParams();
    const navigate = useNavigate();
    const [loading, setLoading] = useState(false);
    const [errors, setErrors] = useState(null);
    const { setNotification } = useStateContext();
    const [clients, setClients] = useState([]);
    const [plans, setPlans] = useState([]);
    const [plan, setPlan] = useState({});
    const [planId, setPlanId] = useState({});

    if (id) {
        const [payment, setPayment] = useState({
            id: null,
            type: "",
            amount: null,
            reference: "",
            client_id: null,
            plan_id: null,
            created_by: "",
        });
    }

    const [payment, setPayment] = useState({
        id: null,
        type: "",
        amount: null,
        reference: "",
        client_id: null,
        plan_id: planId,
        created_by: "",
    });

    const onSubmit = async (e) => {
        e.preventDefault();
        if (payment.id) {
            console.log(payment);
            await axiosClient
                .put(`/payments/${payment.id}`, payment)
                .then((response) => {
                    setNotification("Payment successfully updated");
                    navigate("/payments");
                })
                .catch((err) => {
                    const response = err.response;
                    if (response && response.status == 422) {
                        setErrors(response.data.errors);
                    }
                });
        } else {
            await axiosClient
                .post("/payments", payment)
                .then((response) => {
                    console.log(response);
                    setNotification("Payment successfully created");
                    navigate("/payments");
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
        setLoading(true);

        await axiosClient.get("/clients").then(({ data }) => {
            setLoading(false);
            setClients(data.data);
        });
    };

    const getPlans = async () => {
        setLoading(true);

        await axiosClient.get("/plans").then(({ data }) => {
            setLoading(false);
            setPlans(data.data);
        });
    };

    const getClientPlan = (clientId) => {
        axiosClient.get(`clients/${clientId}/plan`).then(({ data }) => {
            console.log(data);
            setPlan(data);
        });
    };

    const getPayment = async () => {
        setLoading(true);

        await axiosClient.get(`/payments/${id}`).then(({ data }) => {
            setLoading(false);
            setPayment(data);
        });
    };

    if (id) {
        useEffect(() => {
            getPayment();
            getAllClients();
            getPlans();
        }, []);
    }
    useEffect(() => {
        getAllClients();
        getPlans();
    }, []);
    return (
        <div>
            <>
                <div className="bg-white p-5 shadow-md flex flex-col">
                    {payment.id && (
                        <h2 className="text-xl font-lg text-center mb-4">
                            Update Payment
                        </h2>
                    )}
                    {!payment.id && (
                        <h2 className="text-xl font-lg text-center mb-4">
                            Create New Payment
                        </h2>
                    )}

                    <div>
                        {loading && (
                            <div className="text-center">Loading...</div>
                        )}
                        {errors && (
                            <div className="alert">
                                {Object.keys(errors).map((key) => (
                                    <p key={key}>{errors[key][0]}</p>
                                ))}
                            </div>
                        )}
                        {!loading && (
                            <form onSubmit={onSubmit} className="flex flex-col">
                                <label htmlFor="">Type</label>
                                <select
                                    className="py-2 px-2 mb-3 border border-gray-200"
                                    value={payment.type}
                                    onChange={(e) =>
                                        setPayment({
                                            ...payment,
                                            type: e.target.value,
                                        })
                                    }
                                >
                                    <option value="">
                                        --- Select Type ---
                                    </option>
                                    <option value="cash_usd">Cash - USD</option>
                                    <option value="cash_rtgs">
                                        Cash - RTGS
                                    </option>
                                    <option value="ecocash">EcoCash</option>
                                </select>
                                <label htmlFor="">Amount</label>
                                <input
                                    className="py-2 px-2 mb-3 border border-gray-200"
                                    value={payment.amount}
                                    onChange={(e) =>
                                        setPayment({
                                            ...payment,
                                            amount: e.target.value,
                                        })
                                    }
                                    placeholder="50.12"
                                />
                                <label htmlFor="">Reference</label>
                                <input
                                    className="py-2 px-2 mb-3 border border-gray-200"
                                    value={payment.reference}
                                    onChange={(e) =>
                                        setPayment({
                                            ...payment,
                                            reference: e.target.value,
                                        })
                                    }
                                    placeholder="MP230304.1627.L00148 / Cash In Hand"
                                />
                                <label htmlFor="">Client</label>
                                <select
                                    className="py-2 px-2 mb-3 border border-gray-200"
                                    value={payment.client_id}
                                    onChange={(e) =>
                                        setPayment(
                                            {
                                                ...payment,
                                                client_id: e.target.value,
                                            },
                                            getClientPlan(e.target.value)
                                        )
                                    }
                                >
                                    <option value="">
                                        --- Select Client ---
                                    </option>
                                    {clients.map((client) => (
                                        <option
                                            key={client.id}
                                            value={client.id}
                                        >
                                            {client.name} - {client.id_number}
                                        </option>
                                    ))}
                                </select>

                                <label htmlFor="">Plan</label>
                                <input
                                    className="py-2 px-2 mb-3 border border-gray-200"
                                    // value={plan.id}
                                    value={
                                        payment.id ? payment.plan_id : plan.id
                                    }
                                    onChange={(e) => {
                                        payment.id
                                            ? setPayment({
                                                  ...payment,
                                                  plan_id: e.target.value,
                                              })
                                            : setPlanId(e.target.value);
                                    }}
                                    placeholder="13 - 963258741"
                                />
                                <button className="py-3 bg-green-400 text-white">
                                    {!payment.id && "CREATE"}
                                    {payment.id && "UPDATE"}
                                </button>
                            </form>
                        )}
                    </div>
                </div>
            </>
        </div>
    );
};

export default PaymentForm;
