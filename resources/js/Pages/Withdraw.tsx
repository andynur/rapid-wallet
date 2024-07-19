import BlocksLayout from '@/Layouts/BlocksLayout';
import type { PageProps } from '@/types';

export default function Withdraw({ auth }: PageProps) {
    return (
        <BlocksLayout user={auth.user}>
            <div className="grid gap-4 md:grid-cols-2 md:gap-8 lg:grid-cols-4">
                <p>Coming soon...</p>
            </div>
        </BlocksLayout>
    );
}
