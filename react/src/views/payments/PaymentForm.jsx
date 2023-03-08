import React, { useState } from "react";
import { useNavigate, useParams } from "react-router-dom";
import axiosClient from "../../axios-client";
import { useStateContext } from "../../contexts/ContextProvider";

const PaymentForm = () => {
    const { id } = useParams();
    const navigate = useNavigate();
    const [loading, setLoading] = useState(false);
    const [errors, setErrors] = useState(null);
    const { setNotification } = useStateContext();
    const [payment, setPayment] = useState({
        id: null,
        type: "",
        reference: "",
        client_id: null,
        plan_id: null,
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
                    console.log(payment);
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

    const getPayment = async () => {
        setLoading(true);

        await axiosClient.get(`/payments/${id}`).then(({ data }) => {
            console.log(data);
            setLoading(false);
            setPayment(data);
        });
    };

    if (id) {
        useEffect(() => {
            getPayment();
        }, []);
    }
    return (
        <div>
            <>
                <div className="bg-white p-5 shadow-md flex flex-col">
                    {payment.id && (
                        <h2 className="text-xl font-lg text-center mb-4">
                            Update payment: {payment.name}
                        </h2>
                    )}
                    {!payment.id && (
                        <h2 className="text-xl font-lg text-center mb-4">
                            Create New payment
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
                                    name="role_id"
                                >
                                    <option value="">
                                        --- Select Type ---
                                    </option>
                                    <option value="vmum_usd">
                                        V-MUM - USD
                                    </option>
                                    <option value="vmum_rtgs">
                                        V-MUM - RTGS
                                    </option>
                                    <option value="ssb_usd">SSB - USD</option>
                                    <option value="ssb_rtgs">SSB - RTGS</option>
                                </select>
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
                                    name="role_id"
                                >
                                    <option value="">
                                        --- Select Type ---
                                    </option>
                                    <option value="vmum_usd">
                                        V-MUM - USD
                                    </option>
                                    <option value="vmum_rtgs">
                                        V-MUM - RTGS
                                    </option>
                                    <option value="ssb_usd">SSB - USD</option>
                                    <option value="ssb_rtgs">SSB - RTGS</option>
                                </select>
                                <label htmlFor="">Full Name</label>
                                <input
                                    className="py-2 px-2 mb-3 border border-gray-200"
                                    value={payment.name}
                                    onChange={(e) =>
                                        setPayment({
                                            ...payment,
                                            name: e.target.value,
                                        })
                                    }
                                    placeholder="Kudakwashe Masaya"
                                />
                                <label htmlFor="">ID Number</label>
                                <input
                                    className="py-2 px-2 mb-3 border border-gray-200"
                                    value={payment.id_number}
                                    onChange={(e) =>
                                        setPayment({
                                            ...payment,
                                            id_number: e.target.value,
                                        })
                                    }
                                    placeholder="59-123123N89"
                                />
                                <label htmlFor="">EC Number</label>
                                <input
                                    className="py-2 px-2 mb-3 border border-gray-200"
                                    value={payment.ec_number}
                                    onChange={(e) =>
                                        setPayment({
                                            ...payment,
                                            ec_number: e.target.value,
                                        })
                                    }
                                    placeholder="KUD007"
                                />
                                <label htmlFor="">D.O.B</label>
                                <input
                                    className="py-2 px-2 mb-3 border border-gray-200"
                                    value={payment.dob}
                                    onChange={(e) =>
                                        setPayment({
                                            ...payment,
                                            dob: e.target.value,
                                        })
                                    }
                                    type="date"
                                    placeholder="10/12/1996"
                                />
                                <label htmlFor="">Battery Number</label>
                                <input
                                    className="py-2 px-2 mb-3 border border-gray-200"
                                    value={payment.battery_number}
                                    onChange={(e) =>
                                        setPayment({
                                            ...payment,
                                            battery_number: e.target.value,
                                        })
                                    }
                                    placeholder="123456BN"
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
