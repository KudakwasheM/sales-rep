import React, { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import axiosClient from "../../axios-client";
import { useStateContext } from "../../contexts/ContextProvider";

const Payments = () => {
    const [payments, setPayments] = useState([]);
    const [client, setClient] = useState([]);
    const [loading, setLoading] = useState(false);
    const { setNotification } = useStateContext();

    const onDelete = async (payments) => {
        if (!window.confirm("Are you sure you want to delete this payment?")) {
            return;
        }

        await axiosClient.delete(`/payments/${payment.id}`).then(() => {
            setNotification("Payment deleted successfuly.");
            getPayments();
        });
    };

    const getPayments = async () => {
        setLoading(true);

        await axiosClient.get("/payments").then(({ data }) => {
            setLoading(false);
            setPayments(data.payments);
        });
    };

    useEffect(() => {
        getPayments();
    }, []);
    return (
        <>
            <div className="flex flex-row items-center justify-between mb-3">
                <h2 className="font-lg text-2xl">Payments</h2>
                <Link
                    to="/payments/create"
                    className="px-3 py-2 text-white bg-green-700"
                >
                    Add New Payment
                </Link>
            </div>
            <div className="shadow-md p-3 bg-white">
                <table className="table-auto w-full">
                    <thead className="border border-solid border-l-0 border-r-0">
                        <tr className="bg-[#F8F8F8]">
                            <th className="py-3 text-lg font-normal text-start">
                                Amount
                            </th>
                            <th className="py-3 text-lg font-normal text-start">
                                Type
                            </th>
                            <th className="py-3 text-lg font-normal text-start">
                                Reference
                            </th>
                            <th className="py-3 text-lg font-normal text-start">
                                Client Name
                            </th>
                            <th className="py-3 text-lg font-normal text-start">
                                Processed By
                            </th>
                            <th className="py-3 text-lg font-normal text-start">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    {loading && (
                        <tbody>
                            <tr>
                                <td colSpan={7} className="text-center">
                                    Loading...
                                </td>
                            </tr>
                        </tbody>
                    )}
                    {!loading && (
                        <tbody>
                            {payments.map((payment) => (
                                <tr key={payment.id}>
                                    <td className="py-2">{payment.amount}</td>
                                    <td className="py-2">
                                        {payment.type == "cash_usd" &&
                                            "Cash USD"}
                                        {payment.type == "cash_rtgs" &&
                                            "Cash RTGS"}
                                        {payment.type == "ecocash" && "ECOCASH"}
                                    </td>
                                    <td className="py-2">
                                        {payment.reference}
                                    </td>
                                    <td className="py-2">
                                        {payment.client.name}
                                    </td>

                                    <td className="py-2">
                                        {payment.created_by}
                                    </td>
                                    <td className="text-sm py-2">
                                        <Link
                                            to={"/payments/show/" + payment.id}
                                            className="bg-blue-300 p-1 text-white"
                                        >
                                            View
                                        </Link>
                                        &nbsp;
                                        <Link
                                            to={"/payments/" + payment.id}
                                            className="bg-green-300 p-1 text-white"
                                        >
                                            Edit
                                        </Link>
                                        &nbsp;
                                        <button
                                            onClick={(ev) => onDelete(payment)}
                                            className="bg-red-500 text-white p-1"
                                        >
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    )}
                </table>
            </div>
        </>
    );
};

export default Payments;
