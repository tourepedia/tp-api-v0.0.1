<div>
    <b>Hi {{ $user->name }}</b>
    <p>Here is your tasks for next two days.</p>
    <table border="1" style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr>
                <th style="padding: 5px 10px;">#</th>
                <th style="padding: 5px 10px;">Subject</th>
                <th style="padding: 5px 10px;">Due Date (Asia/Kolkata)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($user->tasks as $task)
                <tr>
                    <td style="padding: 5px 10px;">{{ $i }}</td>
                    <td style="padding: 5px 10px;">{{ $task->subject }}</td>
                    <td style="padding: 10px;">{{ $task->due_date->format('l jS \\of F Y h:i:s A') }}</td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
        </tbody>
    </table>
</div>
