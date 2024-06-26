import React, { useEffect, useRef, useState } from "react";
import { useNavigate, useParams } from "react-router-dom";
import axiosClient from "../../axios-client";
import { useStateContext } from "../../contexts/ContextProvider";

const PaymentForm = () => {
    const typeRef = useRef();
    const amountRef = useRef();
    const referenceRef = useRef();
    const clientIdRef = useRef();
    const planIdRef = useRef();
    const navigate = useNavigate();
    const [loading, setLoading] = useState(false);
    const [errors, setErrors] = useState(null);
    const { setNotification } = useStateContext();
    const [clients, setClients] = useState([]);
    const [thePlanId, setThePlanId] = useState();

    const onSubmit = async (e) => {
        e.preventDefault();
        const payment = {
            type: typeRef.current.value,
            amount: amountRef.current.value,
            reference: referenceRef.current.value,
            client_id: clientIdRef.current.value,
            plan_id: planIdRef.current.value,
        };

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
    };

    const getAllClients = async () => {
        setLoading(true);

        await axiosClient.get("/clients").then(({ data }) => {
            setLoading(false);
            setClients(data.data);
        });
    };

    const getClientPlan = (clientId) => {
        axiosClient.get(`clients/${clientId}/plan`).then(({ data }) => {
            setThePlanId(data.client.plans[0].id);
        });
    };

    useEffect(() => {
        getAllClients();
    }, []);
    return (
        <>
            <div className="bg-white p-5 shadow-md flex flex-col">
                <h2 className="text-xl font-lg text-center mb-4">
                    Create New Payment
                </h2>

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
                            <label htmlFor="">Type</label>
                            <select
                                className="py-2 px-2 mb-3 border border-gray-200"
                                ref={typeRef}
                            >
                                <option value="">--- Select Type ---</option>
                                <option value="cash_usd">Cash - USD</option>
                                <option value="cash_rtgs">Cash - RTGS</option>
                                <option value="ecocash">EcoCash</option>
                            </select>
                            <label htmlFor="">Amount</label>
                            <input
                                className="py-2 px-2 mb-3 border border-gray-200"
                                ref={amountRef}
                                placeholder="50.12"
                            />
                            <label htmlFor="">Reference</label>
                            <input
                                className="py-2 px-2 mb-3 border border-gray-200"
                                ref={referenceRef}
                                placeholder="MP230304.1627.L00148 / Cash In Hand"
                            />
                            <label htmlFor="">Client</label>
                            <select
                                className="py-2 px-2 mb-3 border border-gray-200"
                                ref={clientIdRef}
                                onChange={(e) => getClientPlan(e.target.value)}
                            >
                                <option value="">--- Select Client ---</option>
                                {clients.map((client) => (
                                    <option key={client.id} value={client.id}>
                                        {client.name} - {client.id_number}
                                    </option>
                                ))}
                            </select>

                            <label htmlFor="">Plan</label>
                            <input
                                className="py-2 px-2 mb-3 border border-gray-200"
                                // value={plan.id}
                                value={thePlanId}
                                ref={planIdRef}
                                readOnly
                                placeholder="13 - 963258741"
                            />

                            <button className="py-3 bg-green-400 text-white">
                                CREATE
                            </button>
                        </form>
                    )}
                </div>
            </div>
        </>
    );
};

export default PaymentForm;
