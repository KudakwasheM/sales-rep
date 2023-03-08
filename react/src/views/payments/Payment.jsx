import React, { useState } from "react";
import { useParams } from "react-router-dom";
import axiosClient from "../../axios-client";

const Payment = () => {
    const { id } = useParams();
    const [loading, setLoading] = useState(false);
    const [payment, setPayment] = useState({});

    const getPayment = () => {
        setLoading(true);
        axiosClient.get(`/payments/${id}`).then(({ data }) => {
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
        <>
            <div className="bg-white p-5 shadow-md flex flex-col">
                <h2 className="text-xl font-lg text-center mb-4">
                    Showing Payment
                </h2>
                <div>
                    {loading && (
                        <div className="my-2 text-center">Loading...</div>
                    )}
                    {!loading && (
                        <div className="flex flex-row w-full justify-around">
                            <div className="border border-1 w-5/12">
                                <table className="table-fixed">
                                    <tr>
                                        <th className="text-start w-1/2 py-3">
                                            Type
                                        </th>
                                        <td className="w-1/2">
                                            {payment.type}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th className="text-start w-1/2 py-3">
                                            Amount
                                        </th>
                                        <td className="w-1/2">
                                            {payment.amount}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th className="text-start w-1/2 py-3">
                                            Reference
                                        </th>
                                        <td className="w-1/2">
                                            {payment.reference}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th className="text-start w-1/2 py-3">
                                            Client
                                        </th>
                                        <td className="w-1/2">
                                            {payment.client_id}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th className="text-start w-1/2 py-3">
                                            Processed By
                                        </th>
                                        <td className="w-1/2">
                                            {payment.created_by}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </>
    );
};

export default Payment;
